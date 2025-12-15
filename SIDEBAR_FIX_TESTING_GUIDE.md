# Filtered Jobs Sidebar Fix - Testing Guide

## Browser Console Logging

The implementation includes extensive console logging to help with debugging. Open your browser's Developer Tools (F12) and check the Console tab to see:

```javascript
✅ Initialized current filtered jobs on page load: X jobs
✅ Stored current filtered jobs: Y jobs
```

This confirms the feature is working correctly.

---

## Test Cases

### Test 1: Initial Page Load
**What to do:**
1. Open the applicant home page (jobIT)
2. Open browser DevTools Console (F12 → Console tab)
3. Click on any job in the grid view to see detail view

**Expected Result:**
- Console should show: `✅ Initialized current filtered jobs on page load: X jobs`
- Sidebar should display the initial jobs
- Clicking different jobs in sidebar should update the detail view
- ✅ **PASS**: Sidebar shows correct initial jobs

---

### Test 2: Search by Keyword
**What to do:**
1. Open applicant home page
2. Enter a keyword in search box (e.g., "React", "Senior", "Backend")
3. Click "Search" button
4. Wait for results to load
5. Click on any result job to see detail view

**Expected Result:**
- Console should show: `✅ Stored current filtered jobs: Y jobs`
- Sidebar should show ONLY the search result jobs
- All sidebar jobs should match the search keyword
- Clicking different jobs in sidebar should show details
- ✅ **PASS**: Sidebar shows only search result jobs

---

### Test 3: Filter by Location
**What to do:**
1. Open applicant home page
2. Select a location from filter (e.g., "Hà Nội", "TP. Hồ Chí Minh")
3. Click "Search" or apply filter
4. Wait for results
5. Click on any result job

**Expected Result:**
- Sidebar should show ONLY jobs in that location
- All sidebar jobs should display the selected location
- ✅ **PASS**: Sidebar shows only location-filtered jobs

---

### Test 4: Filter by Salary Range
**What to do:**
1. Open applicant home page
2. Click salary filter button
3. Select a salary range (e.g., "5-10 triệu")
4. Apply filter
5. Click on any result

**Expected Result:**
- Sidebar jobs should all be in the selected salary range
- ✅ **PASS**: Sidebar shows only salary-filtered jobs

---

### Test 5: Filter by Job Level/Position
**What to do:**
1. Open applicant home page
2. Click level/position filter
3. Select levels (e.g., "Junior", "Senior")
4. Apply filter
5. Click on a result

**Expected Result:**
- Sidebar jobs should all match selected levels
- ✅ **PASS**: Sidebar shows only level-filtered jobs

---

### Test 6: Filter by Experience
**What to do:**
1. Open applicant home page
2. Click experience filter
3. Select experience levels
4. Apply filter
5. Click a result

**Expected Result:**
- Sidebar jobs match selected experience
- ✅ **PASS**: Sidebar shows only experience-filtered jobs

---

### Test 7: Multiple Filters Combined
**What to do:**
1. Open applicant home page
2. Apply multiple filters:
   - Search: "React"
   - Location: "Hà Nội"
   - Salary: "10-15 triệu"
   - Level: "Senior"
3. Click on any result

**Expected Result:**
- Sidebar shows ONLY jobs matching ALL criteria
- Jobs show as React + Hà Nội + 10-15M + Senior
- ✅ **PASS**: Sidebar shows correctly combined filtered results

---

### Test 8: Pagination with Filtered Results
**What to do:**
1. Apply a filter that returns many results (>8 jobs)
2. Click on a job from page 1
3. Go back to grid view
4. Click "Next page" or page 2 button
5. Click on a job from page 2

**Expected Result:**
- Each page shows different set of filtered results
- When clicking job on page 2, sidebar shows page 2 jobs
- When navigating pages, sidebar updates automatically
- ✅ **PASS**: Pagination works with sidebar sync

---

### Test 9: Switch Between Grid and Detail View
**What to do:**
1. Search for jobs (e.g., "Python")
2. Click job to see detail view
3. Click "Quay lại danh sách" (back button)
4. Verify you're back in grid view
5. Click detail view again

**Expected Result:**
- Back button works correctly
- Sidebar reappears with correct filtered jobs
- Detail view restores properly
- ✅ **PASS**: View switching works correctly

---

### Test 10: Navigate Using Sidebar
**What to do:**
1. Search for jobs
2. Click job 1 to see detail view
3. Click job 3 in sidebar
4. Click job 2 in sidebar
5. Verify detail updates each time

**Expected Result:**
- Detail view updates as you click sidebar jobs
- All sidebar jobs are from search results
- No job outside the search scope appears in sidebar
- ✅ **PASS**: Sidebar navigation works correctly

---

### Test 11: Console Logging Verification
**What to do:**
1. Open browser DevTools (F12)
2. Go to Console tab
3. Perform a search or filter
4. Check console messages

**Expected Result:**
Console should show:
```
✅ Initialized current filtered jobs on page load: 12 jobs
🔍 Full search params: search=react&location=ha-noi
✅ API Response: {success: true, html: "...", ...}
✅ Stored current filtered jobs: 5 jobs
✅ Found 5 jobs
✅ All features initialized successfully
```

✅ **PASS**: All console logging is correct

---

### Test 12: Reset Filters
**What to do:**
1. Apply some filters
2. Click "Reset Filters" or reset button
3. Click on a job to see detail view

**Expected Result:**
- Grid shows all available jobs
- Sidebar shows all jobs (not filtered)
- Console shows appropriate logging
- ✅ **PASS**: Reset clears filters and updates sidebar

---

### Test 13: Clear Search
**What to do:**
1. Enter search keyword
2. Click search
3. Note the filtered results
4. Clear search box or click reset
5. See all jobs returned

**Expected Result:**
- When search is cleared, all jobs appear
- Sidebar updates to show all jobs
- currentFilteredJobs resets to full list
- ✅ **PASS**: Search clear works correctly

---

### Test 14: Mobile Responsive Test
**What to do:**
1. Open DevTools and use mobile view (375px width)
2. Perform a search
3. Click on a job result
4. Verify sidebar appears in mobile layout
5. Try navigating sidebar on mobile

**Expected Result:**
- Sidebar is responsive on mobile
- Job cards still display correctly
- Can click jobs in sidebar
- Detail view adjusts for mobile
- ✅ **PASS**: Mobile layout works

---

### Test 15: Save Job from Sidebar
**What to do:**
1. Search for jobs
2. Click job to see detail view
3. Click save button on sidebar job
4. Verify save functionality works

**Expected Result:**
- Save button appears in sidebar
- Can save jobs from sidebar
- Visual feedback indicates saved status
- ✅ **PASS**: Save functionality works in sidebar

---

## Troubleshooting

### Issue: Sidebar shows wrong jobs
**Solution:**
1. Check console for `currentFilteredJobs` count
2. Verify filter parameters in network tab
3. Check if `extractJobsFromHtml()` is being called
4. Clear browser cache and reload

### Issue: Console shows 0 jobs
**Solution:**
1. Check if API response has HTML content
2. Verify `.job-card-grid` classes exist in HTML
3. Check network tab for API errors
4. Try different search/filter to see if data loads

### Issue: Sidebar doesn't update on pagination
**Solution:**
1. Verify pagination click triggers `loadAllJobs()` or `performSearch()`
2. Check console logs for job count changes
3. Ensure `currentFilteredJobs` is being reassigned

### Issue: Sidebar jobs don't respond to clicks
**Solution:**
1. Verify `attachListCardEvents()` is called after sidebar update
2. Check console for JavaScript errors
3. Verify `.job-card` elements have `data-job-id` attributes
4. Check if `loadJobDetail()` function is accessible

---

## Console Commands for Testing

You can run these in browser console to verify state:

```javascript
// Check current stored jobs
console.log('Current filtered jobs:', currentFilteredJobs);

// Check how many jobs are stored
console.log('Number of jobs:', currentFilteredJobs.length);

// Check job titles
currentFilteredJobs.forEach(job => console.log(job.title));

// Manually update detail view (for testing)
showDetailView(currentFilteredJobs[0].job_id);
```

---

## Success Criteria

✅ Sidebar ALWAYS displays the exact jobs from current search/filter  
✅ When user applies new filter, sidebar updates automatically  
✅ When user navigates pages, sidebar reflects that page's results  
✅ Clicking sidebar jobs loads their details  
✅ Console shows proper logging messages  
✅ No console errors or warnings  
✅ Works on desktop and mobile  

---

## Regression Testing

Make sure these existing features still work:

- [ ] Applying job (modal appears correctly)
- [ ] Saving job (heart icon toggles)
- [ ] View job invitations
- [ ] Sort/filter buttons functional
- [ ] Pagination controls work
- [ ] Back button returns to grid
- [ ] Recommended jobs section works
- [ ] Profile menu accessible
