<?php

/**
 * Test GitHub Copilot AI Recommendation System
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\AI\GitHubCopilotService;

echo "=== TEST GITHUB COPILOT AI ===\n\n";

// 1. Check Token
echo "1. Checking GitHub Token...\n";
$token = env('GITHUB_TOKEN');
if (empty($token) || $token === 'YOUR_GITHUB_TOKEN_HERE') {
    echo "   ❌ GitHub Token chưa được cấu hình!\n";
    exit(1);
}
echo "   ✅ Token found (" . strlen($token) . " characters)\n\n";

// 2. Test Connection
echo "2. Testing GitHub Models API connection...\n";
$service = new GitHubCopilotService();
$result = $service->testConnection();

if ($result['success']) {
    echo "   ✅ GitHub Models API hoạt động!\n";
    echo "   Response: " . json_encode($result['data'], JSON_UNESCAPED_UNICODE) . "\n\n";

    // 3. Test Full Recommendation
    echo "3. Testing Full AI Recommendation...\n";
    $applicant = \App\Models\Applicant::first();
    if ($applicant) {
        echo "   Applicant: {$applicant->first_name} {$applicant->last_name}\n";

        $aiService = new \App\Services\AI\AIRecommendationService();
        $recResult = $aiService->recommendJobsForApplicant($applicant->id_uv, 5, true);

        if ($recResult['success']) {
            echo "   ✅ AI Recommendation thành công!\n";
            echo "   Số recommendations: " . ($recResult['count'] ?? 0) . "\n";
        } else {
            echo "   ❌ Error: " . ($recResult['message'] ?? 'Unknown') . "\n";
        }
    }
} else {
    echo "   ❌ Error: " . $result['error'] . "\n";
}

echo "\n=== DONE ===\n";
