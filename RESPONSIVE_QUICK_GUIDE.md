# Responsive Design - Quick Reference Guide

## 🎯 Key Breakpoints

| Breakpoint | Size | Device | View |
|-----------|------|--------|------|
| XS | 320px | iPhone SE, old phones | Mobile |
| SM | 576px | Tablet portrait | Small tablet |
| MD | 768px | iPad, tablets | Medium |
| LG | 992px | iPad Pro | Large |
| XL | 1200px | Desktop | Extra large |
| XXL | 1400px+ | Large monitor | Extra extra large |

## 📱 Mobile-First Pattern

```css
/* Base styles (mobile, 320px+) */
.element {
    padding: 1rem;
    font-size: 1rem;
}

/* Tablet (576px+) */
@media (min-width: 576px) {
    .element {
        padding: 1.5rem;
    }
}

/* Desktop (768px+) */
@media (min-width: 768px) {
    .element {
        padding: 2rem;
    }
}
```

## 🎨 Responsive Classes

### Grid Layout
```html
<!-- Single column on mobile, 2-column on tablet, 4-column on desktop -->
<div class="grid-4">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
    <div>Item 4</div>
</div>
```

### Display Utilities
```html
<!-- Hidden on mobile, visible on medium+ -->
<div class="d-md-none">Visible on mobile only</div>
<div class="d-md-block">Hidden on mobile</div>
<div class="d-lg-flex">Flex layout on desktop+</div>
```

### Spacing
```html
<!-- Responsive margin/padding -->
<div class="mb-2">Bottom margin varies by screen size</div>
<div class="p-responsive">Responsive padding on all sides</div>
```

### Flex Layout
```html
<!-- Stack on mobile, horizontal on tablet+ -->
<div class="flex-wrap">
    <div>Item 1</div>
    <div>Item 2</div>
</div>
```

## 📐 Column System (Bootstrap Compatible)

```html
<!-- Mobile: 100% width (stacked) -->
<!-- Tablet+: 2-column layout -->
<div class="row">
    <div class="col-md-6">Half width on tablet+</div>
    <div class="col-md-6">Half width on tablet+</div>
</div>

<!-- Mobile: 100% width (stacked) -->
<!-- Desktop: 3-column layout -->
<div class="row">
    <div class="col-lg-4">One third on desktop</div>
    <div class="col-lg-4">One third on desktop</div>
    <div class="col-lg-4">One third on desktop</div>
</div>
```

## 🔠 Typography Scaling

**Mobile:**
- h1: 1.5rem
- h2: 1.3rem
- p: 0.95rem

**Tablet (576px+):**
- h1: 1.7rem
- h2: 1.4rem
- p: 1rem

**Desktop (768px+):**
- h1: 2rem
- h2: 1.5rem
- p: 1rem

**Large Desktop (992px+):**
- h1: 2.25rem
- h2: 1.75rem
- p: 1rem

## 📋 Common Patterns

### Responsive Images
```html
<img src="image.jpg" class="img-fluid" alt="">
```

### Aspect Ratio Container
```html
<div class="aspect-ratio-container aspect-ratio-16-9">
    <img src="image.jpg" alt="">
</div>
```

### Responsive Grid
```html
<div class="grid-3">
    <div class="card">Card 1</div>
    <div class="card">Card 2</div>
    <div class="card">Card 3</div>
</div>
<!-- 1 column on mobile, 2 on tablet, 3 on desktop -->
```

### Hamburger Navigation
```html
<button class="hamburger" id="hamburger">
    <span></span>
    <span></span>
    <span></span>
</button>

<nav id="navmenu" class="navmenu">
    <!-- Menu items -->
</nav>

<script>
    const hamburger = document.getElementById('hamburger');
    const navmenu = document.getElementById('navmenu');
    
    hamburger.addEventListener('click', function() {
        this.classList.toggle('active');
        navmenu.classList.toggle('active');
    });
</script>
```

## 🎯 Touch-Friendly Sizing

- **Buttons**: Min height 44px (mobile), 48px (tablet+)
- **Links**: Minimum 44x44px touch target
- **Padding**: At least 8px around clickable elements
- **Form inputs**: Full width on mobile, proper sizing on desktop

```css
button, .btn, a {
    min-height: 44px;
    padding: 10px 16px;
}

@media (min-width: 576px) {
    button, .btn, a {
        min-height: 48px;
        padding: 12px 20px;
    }
}
```

## 🌙 Dark Mode Support

```css
@media (prefers-color-scheme: dark) {
    :root {
        --text-color: #f3f4f6;
        --bg-color: #111827;
    }
    
    body {
        background-color: var(--bg-color);
        color: var(--text-color);
    }
}
```

## ♿ Accessibility Features

```css
/* Respect user's motion preferences */
@media (prefers-reduced-motion: reduce) {
    * {
        animation-duration: 0.01ms !important;
        transition-duration: 0.01ms !important;
    }
}

/* Safe area insets for notched devices */
@supports (padding: max(0px)) {
    body {
        padding: max(0px, env(safe-area-inset-bottom));
    }
}
```

## 🔍 Testing Checklist

When adding new responsive features:

- [ ] Mobile (320px): Content readable, no horizontal scroll
- [ ] Tablet (576px): Layout adjusts, cards stacked properly
- [ ] Tablet (768px): Full layout visible, navigation shows
- [ ] Desktop (992px+): All features visible and optimized
- [ ] Touch targets >= 44px on mobile
- [ ] Text readable without zoom
- [ ] Images scale properly
- [ ] Forms work on all sizes
- [ ] Hamburger menu works on mobile
- [ ] Dark mode appearance correct

## 📁 File References

### CSS Files
- **`resources/css/responsive.css`** - Core responsive framework (823 lines)
- **`resources/css/responsive-layouts.css`** - Layout utilities and components
- **`resources/css/app.css`** - Main CSS (imports responsive files)

### Blade Templates
- **`resources/views/applicant/partials/header.blade.php`** - Responsive header with hamburger menu
- **`resources/views/home.blade.php`** - Home page with responsive layout
- **`resources/views/home-responsive.blade.php`** - Home page responsive styles

## 🚀 Performance Tips

1. Mobile-first CSS loads smaller initial bundle
2. Use CSS variables for consistent theming
3. Minimize use of `!important` flags
4. Media queries are efficient for responsive design
5. Consider CSS-in-JS for dynamic responsive values

## 🐛 Common Issues & Solutions

### Issue: Content hidden under fixed header
**Solution**: Ensure `body { padding-top: ... }` matches header height
```css
body { padding-top: 70px; }  /* Mobile */

@media (min-width: 768px) {
    body { padding-top: 90px; }  /* Tablet+ */
}
```

### Issue: Mobile menu closes but overlay stays
**Solution**: Remove `.active` class from both hamburger and menu
```javascript
hamburger.classList.remove('active');
navmenu.classList.remove('active');
```

### Issue: Images don't scale on mobile
**Solution**: Use `img-fluid` class or ensure `max-width: 100%`
```html
<img src="image.jpg" class="img-fluid" alt="">
```

### Issue: Text too small on mobile
**Solution**: Use responsive typography scaling
```css
p { font-size: 0.95rem; }
@media (min-width: 576px) { p { font-size: 1rem; } }
```

## 📞 Support

For responsive design questions, refer to:
- RESPONSIVE_DESIGN_REPORT.md - Detailed implementation guide
- W3C Media Queries - https://www.w3.org/TR/mediaqueries-5/
- MDN CSS Media Queries - https://developer.mozilla.org/en-US/docs/Web/CSS/Media_Queries
- Bootstrap Responsive - https://getbootstrap.com/docs/5.3/getting-started/introduction/

---

**Last Updated**: 2024
**System**: Job-IT Platform
**Mobile-First**: Yes ✅
**Dark Mode**: Yes ✅
**Accessibility**: WCAG 2.1 Level A ✅
