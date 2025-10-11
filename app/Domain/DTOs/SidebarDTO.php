<?php
namespace App\Domain\DTOs;

use App\Enums\UserAccountType;
use App\Filament\Pages\AgentData;
use App\Filament\Pages\OcrReport;
use App\Filament\Pages\ProductData;
use App\Filament\Pages\SalesReport;
use App\Filament\Pages\CustomerData;
use App\Filament\Pages\RenewalReport;
use App\Filament\Pages\SalesAnalytics;
use App\Filament\Pages\FinancialReport;
use App\Filament\Pages\ProductionReport;
use App\Filament\Pages\CustomerAnalytics;
use App\Filament\Pages\FinancialAnalytics;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;

class SidebarDTO
{
    public static function items(): array
    {
        return [
            PageNavigationItem::make('Production Report')
                ->translateLabel()
                ->url(ProductionReport::getUrl())
                ->icon('fas-file-lines')
                ->isActiveWhen(function () {
                    return request()->routeIs(ProductionReport::getRouteName());
                })
                ->group('Download Report')
                ->visible(true),
            PageNavigationItem::make('Renewal Report')
                ->translateLabel()
                ->url(RenewalReport::getUrl())
                ->icon('mdi-file-document-refresh')
                ->isActiveWhen(function () {
                    return request()->routeIs(RenewalReport::getRouteName());
                })
                ->group('Download Report')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Financial Report')
                ->translateLabel()
                ->url(FinancialReport::getUrl())
                ->icon('fas-file-invoice-dollar')
                ->isActiveWhen(function () {
                    return request()->routeIs(FinancialReport::getRouteName());
                })
                ->group('Download Report')
                ->visible(function (){
                    return auth()->user()->isSuperAdmin()
                        || with(auth()->user()->account_type, function ($accountType) {
                            return in_array($accountType, [UserAccountType::CompanyAdmin, UserAccountType::AgencyAdmin]);
                        });
                }),
            PageNavigationItem::make('Customer Data')
                ->translateLabel()
                ->url(CustomerData::getUrl())
                ->icon('fas-users-between-lines')
                ->isActiveWhen(function () {
                    return request()->routeIs(CustomerData::getRouteName());
                })
                ->group('Download Data')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Agent Data')
                ->translateLabel()
                ->url(AgentData::getUrl())
                ->icon('fas-user-tie')
                ->isActiveWhen(function () {
                    return request()->routeIs(AgentData::getRouteName());
                })
                ->group('Download Data')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Product Data')
                ->translateLabel()
                ->url(ProductData::getUrl())
                ->icon('fas-box-archive')
                ->isActiveWhen(function () {
                    return request()->routeIs(ProductData::getRouteName());
                })
                ->group('Download Data')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Customer Analytics')
                ->translateLabel()
                ->url(CustomerAnalytics::getUrl())
                ->icon('fas-chart-simple')
                ->isActiveWhen(function () {
                    return request()->routeIs(CustomerAnalytics::getRouteName());
                })
                ->group('Download Analytics')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Financial Analytics')
                ->translateLabel()
                ->url(FinancialAnalytics::getUrl())
                ->icon('heroicon-o-presentation-chart-bar')
                ->isActiveWhen(function () {
                    return request()->routeIs(FinancialAnalytics::getRouteName());
                })
                ->group('Download Analytics')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Sales Analytics')
                ->translateLabel()
                ->url(SalesAnalytics::getUrl())
                ->icon('heroicon-o-presentation-chart-line')
                ->isActiveWhen(function () {
                    return request()->routeIs(SalesAnalytics::getRouteName());
                })
                ->group('Download Analytics')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('Sales Report')
                ->translateLabel()
                ->url(SalesReport::getUrl())
                ->icon('fas-chart-line')
                ->isActiveWhen(function () {
                    return request()->routeIs(SalesReport::getRouteName());
                })
                ->group('Download Financials')
                ->visible(auth()->user()->isAdmin()),
            PageNavigationItem::make('OCR Report')
                ->translateLabel()
                ->url(OcrReport::getUrl())
                ->icon('fas-file-lines')
                ->isActiveWhen(function () {
                    return request()->routeIs(OcrReport::getRouteName());
                })
                ->group('Download Report')
                ->visible(auth()->user()->isAdmin()),
            ];
    }
}
