<?php

namespace App\Services\AI;

/**
 * AIPromptBuilder
 * 
 * Xây dựng các prompt tối ưu cho OpenAI API
 * Đảm bảo format nhất quán và tiết kiệm tokens
 */
class AIPromptBuilder
{
    /**
     * Build system prompt cho việc matching ứng viên - công việc
     * 
     * @param string $context Ngữ cảnh bổ sung (optional)
     * @return string
     */
    public static function buildJobMatchSystemPrompt(string $context = ''): string
    {
        $prompt = <<<PROMPT
            Bạn là AI chuyên gia tuyển dụng IT với 15 năm kinh nghiệm tại Việt Nam.

NHIỆM VỤ: Phân tích và đánh giá độ phù hợp giữa ứng viên và công việc.

QUY TẮC ĐÁNH GIÁ:
1. SEMANTIC MATCHING (Hiểu ngữ nghĩa):
           - "PHP, Laravel, MySQL" → phù hợp với "Backend Developer"
   - "React, Vue, JavaScript" → phù hợp "Frontend Developer"
   - "Python, TensorFlow, ML" → phù hợp "AI/ML Engineer"
   
2. TRANSFERABLE SKILLS:
   - Java Developer có thể học C# nhanh
   - React Developer có thể chuyển sang Vue
   - Backend có thể học DevOps

3. TRỌNG SỐ ĐIỂM:
   - Skills: 30%
   - Experience: 25%
   - Location: 20%
   - Language: 15%
   - Salary: 5%
   - Education: 5%

4. THANG ĐIỂM (0-100):
   - 85-100: Rất phù hợp (Highly Recommended)
   - 70-84: Phù hợp (Recommended)
   - 50-69: Cân nhắc (Consider)
   - 0-49: Không phù hợp (Not Recommended)

OUTPUT FORMAT: JSON (xem user prompt)
PROMPT;

        if ($context) {
            $prompt .= "\n\nNGỮ CẢNH BỔ SUNG:\n{$context}";
        }

        return $prompt;
    }

    /**
     * Build user prompt cho phân tích 1 ứng viên - 1 công việc
     * 
     * @param string $applicantText Thông tin ứng viên đã format
     * @param string $jobText Thông tin công việc đã format
     * @return string
     */
    public static function buildSingleMatchUserPrompt(string $applicantText, string $jobText): string
    {
        return <<<PROMPT
Phân tích độ phù hợp giữa ứng viên và công việc sau:

{$applicantText}

{$jobText}

TRẢ VỀ JSON VỚI CẤU TRÚC:
{
    "match_score": <0-100>,
    "skill_score": <0-100>,
    "experience_score": <0-100>,
    "education_score": <0-100>,
    "language_score": <0-100>,
    "location_score": <0-100>,
    "salary_score": <0-100>,
    "strengths": ["điểm mạnh 1", "điểm mạnh 2", "điểm mạnh 3"],
    "weaknesses": ["điểm yếu 1", "điểm yếu 2"],
    "ai_reasoning": "Giải thích ngắn gọn (2-3 câu)",
    "recommendation": "highly_recommended|recommended|consider|not_recommended",
    "improvement_suggestions": ["gợi ý 1", "gợi ý 2"]
}
PROMPT;
    }

    /**
     * Build user prompt cho phân tích 1 ứng viên - NHIỀU công việc
     * 
     * @param string $applicantText Thông tin ứng viên
     * @param array $jobsData Mảng [job_id => formatted_text]
     * @return string
     */
    public static function buildMultiJobMatchUserPrompt(string $applicantText, array $jobsData): string
    {
        $jobsSection = "";
        foreach ($jobsData as $jobId => $jobText) {
            $jobsSection .= "\n\n--- CÔNG VIỆC #{$jobId} ---\n{$jobText}";
        }

        return <<<PROMPT
Phân tích và xếp hạng độ phù hợp của ứng viên với các công việc sau:

{$applicantText}

===== DANH SÁCH CÔNG VIỆC ====={$jobsSection}

TRẢ VỀ JSON VỚI CẤU TRÚC:
{
    "applicant_summary": "Tóm tắt profile ứng viên (1-2 câu)",
    "recommendations": [
        {
            "job_id": <id>,
            "match_score": <0-100>,
            "skill_score": <0-100>,
            "experience_score": <0-100>,
            "education_score": <0-100>,
            "language_score": <0-100>,
            "location_score": <0-100>,
            "salary_score": <0-100>,
            "strengths": ["..."],
            "weaknesses": ["..."],
            "ai_reasoning": "...",
            "recommendation": "highly_recommended|recommended|consider|not_recommended"
        }
    ],
    "best_match_job_id": <id của job phù hợp nhất>,
    "career_advice": "Lời khuyên nghề nghiệp cho ứng viên"
}

LƯU Ý:
- Sắp xếp recommendations theo match_score GIẢM DẦN
- Chỉ trả về jobs có match_score >= 40
- Nếu không có job nào phù hợp, trả về recommendations: []
PROMPT;
    }

    /**
     * Build user prompt cho phân tích NHIỀU ứng viên - 1 công việc (cho nhà tuyển dụng)
     * 
     * @param string $jobText Thông tin công việc
     * @param array $applicantsData Mảng [applicant_id => formatted_text]
     * @return string
     */
    public static function buildMultiApplicantMatchUserPrompt(string $jobText, array $applicantsData): string
    {
        $applicantsSection = "";
        foreach ($applicantsData as $applicantId => $applicantText) {
            $applicantsSection .= "\n\n--- ỨNG VIÊN #{$applicantId} ---\n{$applicantText}";
        }

        return <<<PROMPT
Phân tích và xếp hạng các ứng viên cho công việc sau:

{$jobText}

===== DANH SÁCH ỨNG VIÊN ====={$applicantsSection}

TRẢ VỀ JSON VỚI CẤU TRÚC:
{
    "job_summary": "Tóm tắt yêu cầu công việc (1-2 câu)",
    "candidates": [
        {
            "applicant_id": <id>,
            "match_score": <0-100>,
            "skill_score": <0-100>,
            "experience_score": <0-100>,
            "education_score": <0-100>,
            "language_score": <0-100>,
            "location_score": <0-100>,
            "salary_score": <0-100>,
            "strengths": ["..."],
            "weaknesses": ["..."],
            "ai_reasoning": "...",
            "hiring_recommendation": "should_interview|consider|not_suitable"
        }
    ],
    "top_candidate_id": <id ứng viên tốt nhất>,
    "hiring_advice": "Lời khuyên cho nhà tuyển dụng"
}

LƯU Ý:
- Sắp xếp candidates theo match_score GIẢM DẦN
- Chỉ trả về candidates có match_score >= 40
- Ưu tiên ứng viên có skills match chính xác với yêu cầu
PROMPT;
    }

    /**
     * Build system prompt cho nhà tuyển dụng (phân tích ứng viên)
     * 
     * @return string
     */
    public static function buildRecruiterSystemPrompt(): string
    {
        return <<<PROMPT
Bạn là AI trợ lý tuyển dụng IT chuyên nghiệp tại Việt Nam.

VAI TRÒ: Giúp nhà tuyển dụng đánh giá và xếp hạng ứng viên.

TIÊU CHÍ ĐÁNH GIÁ:
1. KỸ NĂNG KỸ THUẬT (35%):
   - Match trực tiếp với job requirements
   - Transferable skills
   - Công nghệ trending

2. KINH NGHIỆM (25%):
   - Số năm kinh nghiệm
   - Độ liên quan của kinh nghiệm
   - Quy mô dự án đã làm

3. VĂN HÓA PHÙ HỢP (15%):
   - Mức lương mong muốn vs budget
   - Địa điểm làm việc
   - Loại hình công việc

4. TIỀM NĂNG PHÁT TRIỂN (15%):
   - Học vấn & chứng chỉ
   - Dự án cá nhân
   - Tốc độ học hỏi (suy từ career path)

5. ĐỘ ỔN ĐỊNH (10%):
   - Tenure tại công ty cũ
   - Lý do chuyển việc (nếu có)

HIRING RECOMMENDATION:
- should_interview: Nên mời phỏng vấn ngay
- consider: Cân nhắc, cần xem thêm
- not_suitable: Không phù hợp
PROMPT;
    }

    /**
     * Build prompt đơn giản cho test connection
     * 
     * @return array [system, user]
     */
    public static function buildTestPrompt(): array
    {
        return [
            'system' => 'Bạn là assistant. Trả lời ngắn gọn.',
            'user' => 'Nói "OK" nếu bạn hoạt động bình thường.'
        ];
    }

    /**
     * Tối ưu text để giảm tokens
     * 
     * @param string $text
     * @return string
     */
    public static function optimizeText(string $text): string
    {
        // Loại bỏ multiple spaces
        $text = preg_replace('/\s+/', ' ', $text);

        // Loại bỏ lines trống liên tiếp
        $text = preg_replace('/\n\s*\n\s*\n/', "\n\n", $text);

        // Trim
        $text = trim($text);

        return $text;
    }

    /**
     * Ước tính số tokens của text (rough estimate)
     * Rule: ~4 characters = 1 token cho tiếng Việt
     * 
     * @param string $text
     * @return int
     */
    public static function estimateTokens(string $text): int
    {
        // Tiếng Việt có dấu nên tốn nhiều tokens hơn tiếng Anh
        // Ước tính: ~3-4 ký tự = 1 token
        return (int) ceil(mb_strlen($text) / 3.5);
    }

    /**
     * Kiểm tra xem text có vượt quá giới hạn tokens không
     * 
     * @param string $text
     * @param int $maxTokens Default 4000 (để có chỗ cho response)
     * @return bool
     */
    public static function isWithinTokenLimit(string $text, int $maxTokens = 4000): bool
    {
        return self::estimateTokens($text) <= $maxTokens;
    }

    /**
     * Truncate text nếu vượt quá giới hạn
     * 
     * @param string $text
     * @param int $maxTokens
     * @return string
     */
    public static function truncateToTokenLimit(string $text, int $maxTokens = 4000): string
    {
        $estimatedTokens = self::estimateTokens($text);

        if ($estimatedTokens <= $maxTokens) {
            return $text;
        }

        // Tính số ký tự cần giữ lại
        $ratio = $maxTokens / $estimatedTokens;
        $maxChars = (int) floor(mb_strlen($text) * $ratio * 0.95); // 95% để an toàn

        return mb_substr($text, 0, $maxChars) . "\n...[Đã cắt bớt do quá dài]";
    }

    /**
     * Build prompt cho việc extract skills từ mô tả công việc
     * (Dùng cho việc tự động tag skills)
     * 
     * @param string $jobDescription
     * @return array [system, user]
     */
    public static function buildSkillExtractionPrompt(string $jobDescription): array
    {
        $system = <<<PROMPT
Bạn là chuyên gia phân tích job description trong lĩnh vực IT.
Nhiệm vụ: Trích xuất các kỹ năng/công nghệ được yêu cầu.
PROMPT;

        $user = <<<PROMPT
Trích xuất skills từ job description sau:

{$jobDescription}

TRẢ VỀ JSON:
{
    "technical_skills": ["skill1", "skill2"],
    "soft_skills": ["skill1", "skill2"],
    "tools": ["tool1", "tool2"],
    "frameworks": ["framework1", "framework2"]
}
PROMPT;

        return [
            'system' => $system,
            'user' => $user
        ];
    }
}
