<div class="job-empty-state" style="text-align: center; padding: 4rem 2rem; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <div style="width: 120px; height: 120px; margin: 0 auto 2rem; background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);">
        <i class="bi bi-search" style="font-size: 3rem; color: white;"></i>
    </div>

    <h3 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 0.75rem;">
        Không tìm thấy công việc phù hợp
    </h3>

    <p style="font-size: 1rem; color: #6b7280; margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">
        Thử điều chỉnh từ khóa tìm kiếm hoặc bộ lọc để tìm được công việc phù hợp với bạn
    </p>

    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <button class="btn btn-outline-primary" onclick="document.getElementById('searchInput').focus()" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600;">
            <i class="bi bi-search me-2"></i>Thử từ khóa khác
        </button>

        <button class="btn btn-primary" onclick="document.getElementById('resetFiltersBtn').click()" style="padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%); border: none;">
            <i class="bi bi-arrow-clockwise me-2"></i>Xóa bộ lọc
        </button>
    </div>

    <div style="margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid #e5e7eb;">
        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">Gợi ý tìm kiếm:</p>
        <div style="display: flex; gap: 0.5rem; justify-content: center; flex-wrap: wrap;">
            <span class="badge bg-light text-dark" style="padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: 1px solid #e5e7eb;" onclick="document.getElementById('searchInput').value='Frontend Developer'; document.getElementById('searchBtn').click();">
                Frontend Developer
            </span>
            <span class="badge bg-light text-dark" style="padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: 1px solid #e5e7eb;" onclick="document.getElementById('searchInput').value='Backend Developer'; document.getElementById('searchBtn').click();">
                Backend Developer
            </span>
            <span class="badge bg-light text-dark" style="padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: 1px solid #e5e7eb;" onclick="document.getElementById('searchInput').value='Fullstack'; document.getElementById('searchBtn').click();">
                Fullstack
            </span>
            <span class="badge bg-light text-dark" style="padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: 1px solid #e5e7eb;" onclick="document.getElementById('searchInput').value='DevOps'; document.getElementById('searchBtn').click();">
                DevOps
            </span>
        </div>
    </div>
</div>