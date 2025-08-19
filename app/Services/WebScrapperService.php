<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;
use Exception;

class WebScraperService
{
    protected $config;
    protected $crawler;

    public function __construct(array $config = [])
    {
        $this->config = array_merge([
            'timeout' => 30,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'retry_attempts' => 3,
        ], $config);
    }

    public function scrape(string $url, array $customConfig = [])
    {
        $this->config = array_merge($this->config, $customConfig);

        try {
            $html = $this->fetchHtml($url);
            $this->crawler = new Crawler($html);

            return $this->extractData();
        } catch (Exception $e) {
            Log::error("Scraping failed for {$url}: " . $e->getMessage());
            throw $e;
        }
    }

    protected function fetchHtml(string $url): string
    {
        $attempts = 0;
        
        while ($attempts < $this->config['retry_attempts']) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => $this->config['user_agent']
                ])->timeout($this->config['timeout'])
                  ->get($url);

                if ($response->successful()) {
                    return $response->body();
                }
            } catch (Exception $e) {
                Log::warning("Attempt " . ($attempts + 1) . " failed for {$url}");
            }
            
            $attempts++;
            sleep(1); // Wait before retry
        }

        throw new Exception("Failed to fetch URL after {$this->config['retry_attempts']} attempts");
    }

    protected function extractData(): array
    {
        $result = [
            'metadata' => [
                'scraped_at' => now()->toISOString(),
                'url' => request()->fullUrl(),
            ],
            'sections' => [],
        ];

        // Example: Scrape tables from a div with id=vehicle-data
        $container = $this->crawler->filter('#vehicle-data');
        
        if ($container->count() === 0) {
            throw new Exception('Target container (#vehicle-data) not found');
        }

        $container->filter('section')->each(function (Crawler $section, $i) use (&$result) {
            $sectionData = [
                'title' => $section->filter('h2, h3')->text('No title'),
                'tables' => [],
            ];

            $section->filter('table')->each(function (Crawler $table, $j) use (&$sectionData) {
                $tableData = [
                    'rows' => [],
                ];

                $table->filter('tr')->each(function (Crawler $row) use (&$tableData) {
                    $cells = $row->filter('td, th')->each(function (Crawler $cell) {
                        return $cell->text();
                    });

                    if (count($cells) === 4) {
                        $tableData['rows'][] = [
                            'pair1' => [
                                'key' => $cells[0],
                                'value' => $cells[1],
                            ],
                            'pair2' => [
                                'key' => $cells[2],
                                'value' => $cells[3],
                            ],
                        ];
                    }
                });

                if (!empty($tableData['rows'])) {
                    $sectionData['tables'][] = $tableData;
                }
            });

            if (!empty($sectionData['tables'])) {
                $result['sections'][] = $sectionData;
            }
        });

        return $result;
    }

    public function saveToDatabase(array $data, string $modelClass)
    {
        // Implement your database saving logic here
        // Example:
        // return $modelClass::create($data);
    }
}