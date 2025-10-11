<?php

namespace App\Domain\DTOs\API;

use App\Enums\QuoteOrigin;
use App\Enums\QuoteState;
use App\Enums\UAEArea;
use App\Models\IcUser;
use App\Models\Product;
use App\Models\Quote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class QuoteDTO
{
    private $uid;
    private $status;
    private $reference;
    private $city;
    private $total;
    private $created_at;
    private $paid_at;
    private $sponsor;
    private $members;
    private $policy;
    private $user;
    private $product;
    private $payment_link = null;
    private $state;

    public function __construct(protected $data)
    {
        $this->fill($data);
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'status' => $this->status,
            'state' => $this->state,
            'reference' => $this->reference,
            'city' => $this->city,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'payment_link' => $this->payment_link,
            'paid_at' => $this->paid_at,
            'policy' => $this->policy?->toArray(),
            'sponsor' => $this->sponsor?->toArray(),
            'members' => $this->members,
        ];
    }

    public function validate($payload, $rules)
    {
        try {
            Validator::validate($payload, $rules);
        } catch (ValidationException $exception) {
            throw $exception;
        }
    }

    public function fill(array $data){
        $this->uid = $data['uid']?? null;
        $this->status = isset($data['status']) ? $data['status']?->getLabel() : null;
        $this->reference = $data['reference']?? null;
        $this->city = $data['city']?? null;
        $this->total = $data['total']?? null;
        $this->created_at = $data['created_at']?? null;
        $this->paid_at = $data['paid_at']?? null;
        $this->payment_link = isset($data['uid']) ? route('payment-link', ["record" => $data['uid']]) : null;
        $this->sponsor = ($data['sponsor'] ?? null) ? new SponsorDTO($data['sponsor']) : null;
        $this->policy = ($data['policy'] ?? null) ? new PolicyDTO($data['policy']) : null;
        $this->state = $data['state'] ?? null;

        $this->user = $data['user_id'];
        $this->product = $data['product_id'];

        $this->members = collect($data['members'])->map(function ($member) {
            $memberDTO = new MemberDTO($member);
            return $memberDTO->toArray();
        });
    }

    public function getPayloadForCreation(): array
    {
        $user = IcUser::where('id', $this->user)->firstOrFail();
        try {
            $product = $user->products()->where('uid', $this->product)->firstOrFail();
        } catch (\Exception $exception) {
            throw new \Exception("The Product {$this->product} Not Found");
        }
        $quote_state = $product->allow_bulk ? QuoteState::Pending : QuoteState::Approved;
        $paylod =  [
            "city" => UAEArea::tryFrom($this->city),
            "product_id" => $product->id,
            "user_id" => $user->id,
            "created_from" => QuoteOrigin::Api,
            "state" => $quote_state
        ];

        $this->validate($paylod, [
            'city' => ['required', Rule::enum(UAEArea::class)],
            'product_id' => ['required'],
            'user_id' => ['required'],
        ]);

        return $paylod;
    }

    public function create(){
        try {
            DB::connection('ic_mysql')->beginTransaction();
            $createPayload = $this->getPayloadForCreation();
            $quote = Quote::create($createPayload);
            // create sponsor
            $this->sponsor->setQuoteId($quote->id);
            $this->sponsor->create();
            // create members
            $this->members->each(function ($member) use ($quote) {
                $memberDTO = new MemberDTO($member);
                $memberDTO->setQuoteId($quote->id);
                $memberDTO->setProduct($quote->product->id);
                return $memberDTO->create();
            });
            DB::connection('ic_mysql')->commit();
        } catch (\Exception $e) {
            DB::connection('ic_mysql')->rollBack();
            throw $e;
        }

        $quote->refresh();
        $this->fill($quote->load('members', 'sponsor', 'policy', 'user')->append('status')->toArray());
    }
}
