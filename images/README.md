# ColdMan Refrigeration Logo

## Logo Setup Instructions

The website is now configured to display a ColdMan Refrigeration logo image in the navigation bar across all pages.

### Logo File Requirements

**File Name:** `coldman-logo.png`  
**Location:** `/images/coldman-logo.png`

### Recommended Specifications

- **Format:** PNG with transparency (recommended) or JPEG
- **Width:** 300-400px (high resolution for crisp display)
- **Height:** Proportional to width (maintain aspect ratio)
- **Dimensions Ratio:** Roughly 3:1 or 4:1 (landscape orientation works best)
- **File Size:** Under 100KB for optimal loading

### Logo Dimensions Across Devices

The CSS is configured to display the logo at:
- **Desktop:** 55px max height
- **Tablet:** 48px max height  
- **Mobile:** 45px max height

The logo will scale proportionally while maintaining its aspect ratio.

### How to Add Your Logo

1. **Prepare your logo image** - Ensure it's in PNG or JPEG format with good quality
2. **Save it** as `coldman-logo.png` in this directory (`/images/`)
3. **Verify** - Refresh any of the pages (index.html, about.html, services.html, projects.html, contact.html, privacy.html, or terms.html) in your browser
4. **Test responsiveness** - Check how it looks on mobile, tablet, and desktop views

### Current Configuration

All pages now reference:
```html
<img src="images/coldman-logo.png" alt="ColdMan Refrigeration" class="header-logo">
```

The `.header-logo` CSS class handles:
- Responsive sizing across all devices
- Proper aspect ratio maintenance
- Smooth hover effects
- Vertical centering in the navigation bar

### Responsive Behavior

- On **desktop (992px+):** Logo displays at full 55px height
- On **tablet (768px-992px):** Logo scales down to 48px height
- On **mobile (<768px):** Logo shows at 45px height in centered navigation

Your logo will automatically scale and display perfectly across all screen sizes!
