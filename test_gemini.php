<?php

/**
 * Test Gemini AI Recommendation System
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\AI\GeminiService;
use App\Services\AI\DataCollector\ApplicantDataCollector;
use App\Services\AI\DataCollector\JobDataCollector;

echo "=== TEST GEMINI AI RECOMMENDATION SYSTEM ===\n\n";

// 1. Check API Key
echo "1. Checking Gemini API Key...\n";
$apiKey = env('GEMINI_API_KEY');
if (empty($apiKey) || $apiKey === 'YOUR_GEMINI_API_KEY_HERE') {
    echo "   ❌ Gemini API Key chưa được cấu hình!\n";
    exit(1);
}
echo "   ✅ API Key found (" . strlen($apiKey) . " characters)\n\n";

// 2. Test GeminiService connection
echo "2. Testing GeminiService connection...\n";
$geminiService = new GeminiService();
$testResult = $geminiService->testConnection();

if ($testResult['success']) {
    echo "   ✅ Gemini API hoạt động!\n";
    echo "   Response: " . json_encode($testResult['data'], JSON_UNESCAPED_UNICODE) . "\n\n";
} else {
    echo "   ❌ Gemini API Error: " . $testResult['error'] . "\n\n";
    exit(1);
}

// 3. Test ApplicantDataCollector
echo "3. Testing ApplicantDataCollector...\n";
$applicantCollector = new ApplicantDataCollector();
$applicant = \App\Models\Applicant::first();
if ($applicant) {
    echo "   Found applicant: ID={$applicant->id_uv}, Name={$applicant->first_name} {$applicant->last_name}\n";
    $applicantData = $applicantCollector->collect($applicant->id_uv);
    if ($applicantData['success']) {
        echo "   ✅ Applicant data collected successfully\n";
    } else {
        echo "   ❌ Error: " . $applicantData['error'] . "\n";
    }
} else {
    echo "   ⚠️ No applicants found\n";
}
echo "\n";

// 4. Test JobDataCollector
echo "4. Testing JobDataCollector...\n";
$jobCollector = new JobDataCollector();
$job = \App\Models\JobPost::where('status', 'active')->first();
if ($job) {
    echo "   Found job: ID={$job->id}, Title={$job->title}\n";
    $jobCount = \App\Models\JobPost::where('status', 'active')->count();
    echo "   Total active jobs: {$jobCount}\n";
    echo "   ✅ Job data ready\n";
} else {
    echo "   ⚠️ No active jobs found\n";
}
echo "\n";

// 5. Test Full AI Recommendation (nếu có đủ data)
if ($applicant && $job && $testResult['success']) {
    echo "5. Testing Full AI Job Recommendation...\n";
    echo "   (This may take 10-30 seconds...)\n";

    $aiService = new \App\Services\AI\AIRecommendationService();
    $result = $aiService->recommendJobsForApplicant($applicant->id_uv, 5, true);

    if ($result['success']) {
        echo "   ✅ AI Recommendation thành công!\n";
        echo "   Số recommendations: " . ($result['count'] ?? 0) . "\n";
        if (isset($result['career_advice'])) {
            echo "   Career Advice: " . substr($result['career_advice'], 0, 100) . "...\n";
        }
    } else {
        echo "   ❌ Error: " . ($result['message'] ?? $result['error'] ?? 'Unknown error') . "\n";
    }
}

echo "\n=== TEST COMPLETED ===\n";
