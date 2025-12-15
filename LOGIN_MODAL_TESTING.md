# 🧪 Quick Testing Guide - Login Modal Feature

## ✅ Được Cập Nhật

Tất cả 9 điểm gọi login redirect đã được thay thế bằng `showLoginModal()`:

```
1. Save Job (handleSaveJob)              ✅
2. Apply Job from Detail (attachDetailButtons)  ✅
3. Accept Invitation                      ✅
4. Respond to Invitation (API 401)        ✅
5. Reject Invitation                      ✅
6. Apply Job from Grid (handleApplyClick)  ✅
7. Apply Recommended Job                  ✅
8. Save Recommended Job                   ✅
9. Apply from Recommended Detail          ✅
```

---

## 🧑‍💻 Cách Test Nhanh

### **Tạo Test User (Nếu cần):**
```sql
INSERT INTO users (email, password, role) 
VALUES ('test@example.com', bcrypt('password123'), 'applicant');
```

### **Test Scenario 1: Save Job (Lưu công việc)**
```
1. Logout (or Private Window)
2. Go to homepage
3. Click "❤️ Lưu" button on any job
4. ✅ Login modal should appear
5. Login
6. ✅ Modal closes, page stays same
7. Job should be saved
```

### **Test Scenario 2: Apply Job (Ứng tuyển)**
```
1. Logout (or Private Window)
2. Go to homepage
3. Click "Ứng tuyển ngay" button
4. ✅ Login modal should appear
5. Login
6. ✅ Apply modal shows automatically
7. Complete application
```

### **Test Scenario 3: Recommended Jobs**
```
1. Logout (or Private Window)
2. Scroll to "Gợi ý việc làm" section
3. Click "Ứng tuyển" or "Lưu" on any job card
4. ✅ Login modal should appear
5. Login
6. ✅ Continue with action
```

---

## 🔍 Verification Checklist

- [ ] Save job button → Login modal appears
- [ ] Apply button → Login modal appears
- [ ] Accept invitation button → Login modal appears
- [ ] Reject invitation button → Login modal appears
- [ ] Modal has correct form (email/password fields)
- [ ] Login button works in modal
- [ ] After login, user returns to same page (no redirect)
- [ ] User can continue original action after login
- [ ] Modal can be closed (ESC key or X button)
- [ ] Toast notifications appear correctly

---

## 🐛 Debugging Tips

### **Check if Modal Appears:**
Open Browser DevTools (F12) → Console
```javascript
// Run this to test modal manually:
showLoginModal();

// Check if modal element exists:
document.getElementById('loginModal');
// Should return the DOM element
```

### **Check Auth Status:**
```javascript
checkAuth();
// Returns: true/false
```

### **Monitor Events:**
Look for console logs:
- "Login modal not found..." → Modal element is missing
- Function calls appear smoothly without redirects

---

## 📊 Expected Behavior

| Action | User Status | Before | After |
|--------|-------------|--------|-------|
| Click Save | Not Logged In | Redirect to /login | Modal appears |
| Click Apply | Not Logged In | Redirect to /login | Modal appears |
| Accept Invite | Not Logged In | Redirect to /login | Modal appears |
| Login in Modal | - | Form submission | Page stays, modal closes |
| Press ESC | Modal open | - | Modal closes |

---

## 🚀 Browser DevTools Console Test

Paste in console when user not logged in:
```javascript
// Test the function
showLoginModal();

// Check Bootstrap modal creation
const loginModal = document.getElementById('loginModal');
console.log('Modal exists:', !!loginModal);

// Manually create modal
if (loginModal) {
    const modal = new bootstrap.Modal(loginModal);
    modal.show();
}
```

---

## 📱 Mobile Testing

- Test on iPhone (Safari)
- Test on Android (Chrome)
- Modal should be centered and responsive
- Login form should be readable
- Buttons should be easily tappable

---

## ⚠️ Potential Issues & Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| Modal doesn't show | `#loginModal` not found in HTML | Check HTML has the modal element |
| Modal shows but button disabled | Script loaded before DOM ready | Check `DOMContentLoaded` event |
| After login, still on login modal | Form submission issue | Check form action route |
| User redirected after login | Server-side redirect | Check auth controller redirect logic |

---

## ✨ Success Indicators

✅ All working correctly if:
1. Modal appears instead of page redirect
2. No page reload during login process
3. User stays on same URL after login
4. Toast notifications are visible
5. Modal closes after successful login
6. Can continue original action (apply/save) after login

---

**Last Updated:** 2025-12-15
