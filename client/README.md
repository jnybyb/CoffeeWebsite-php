# Coffee Crop Monitoring System - Frontend

Professional HTML/CSS frontend for the Coffee Crop Monitoring Web Application. Converted from React to pure HTML/CSS with optional JavaScript for interactivity.

## Project Structure

```
frontend/
├── public/
│   ├── css/
│   │   ├── common/           # Global styles and utilities
│   │   │   ├── variables.css  # CSS custom properties (colors, spacing, etc.)
│   │   │   └── layout.css     # Layout utilities (flexbox, grid, etc.)
│   │   ├── components/        # Component-specific styles
│   │   │   ├── buttons.css    # Button variants and sizes
│   │   │   ├── forms.css      # Form elements and inputs
│   │   │   ├── cards.css      # Card container component
│   │   │   ├── header.css     # Navigation header
│   │   │   ├── sidebar.css    # Side navigation menu
│   │   │   ├── tables.css     # Table and data grid styling
│   │   │   └── modals.css     # Modal dialogs
│   │   ├── pages/             # Page-specific styles
│   │   │   ├── auth.css       # Login/authentication page
│   │   │   ├── dashboard.css  # Dashboard page
│   │   │   ├── farm-monitoring.css
│   │   │   ├── beneficiaries.css
│   │   │   └── reports.css
│   │   ├── login.css          # Login page styling
│   │   └── main.css           # Global styles
│   ├── images/
│   │   ├── logos/
│   │   ├── backgrounds/
│   │   ├── icons/
│   │   └── avatars/
│   └── js/
│       └── common.js          # Common JavaScript utilities
├── src/
│   ├── pages/                 # Page templates
│   │   ├── login.html
│   │   ├── dashboard.html
│   │   ├── farm-monitoring.html
│   │   ├── beneficiaries.html
│   │   └── reports.html
│   └── components/
│       ├── layout/            # Layout components
│       │   ├── header.html
│       │   ├── sidebar.html
│       │   └── footer.html
│       └── ui/                # UI components
│           ├── alert-modal.html
│           ├── data-grid.html
│           ├── pagination.html
│           ├── form-fields.html
│           ├── buttons.html
│           └── loading-spinner.html
├── index.html                 # Landing/home page
└── README.md                  # This file

```

## Getting Started

### Prerequisites
- PHP 7.0+ (for development server)
- Modern web browser (Chrome, Firefox, Safari, Edge)
- Text editor or IDE (VS Code recommended)

### Installation

1. **Clone or download the project**
   ```bash
   cd frontend
   ```

2. **Start development server**
   ```bash
   # Using PHP built-in server
   php -S localhost:8000
   
   # Or using Node.js http-server
   npx http-server
   ```

3. **Open in browser**
   ```
   http://localhost:8000
   ```

## Features

### Pages

#### 1. **Login** (`/src/pages/login.html`)
- Professional authentication interface
- Dark green Coffee Crop Monitoring branding
- Form validation and error handling
- Responsive design for mobile devices

#### 2. **Dashboard** (`/src/pages/dashboard.html`)
- Statistics overview cards
- Recent activity feed
- Performance metrics
- Quick access to main features

#### 3. **Farm Monitoring** (`/src/pages/farm-monitoring.html`)
- Real-time farm status tracking
- Plot monitoring and alerts
- Crop health indicators
- Interactive map view

#### 4. **Beneficiaries** (`/src/pages/beneficiaries.html`)
- Beneficiary management table
- Profile information display
- Status tracking
- Quick action buttons

#### 5. **Reports** (`/src/pages/reports.html`)
- Multiple report types
- Data visualization
- Export functionality
- Filtering and date range selection

### Components

#### Layout Components
- **Header**: Navigation bar with logo, search, and user menu
- **Sidebar**: Collapsible navigation menu with icons
- **Footer**: Site footer with links and information

#### UI Components
- **Alert Modal**: Customizable alerts, confirmations, and notifications
- **Data Grid**: Sortable, searchable data table with pagination
- **Pagination**: Navigation controls for paginated content
- **Form Fields**: Reusable input components with validation
- **Buttons**: Multiple button variants (primary, secondary, success, error, outline, ghost)
- **Loading Spinner**: Full-page loading indicator

## Styling

### CSS Architecture

The project uses a **utilities-first** CSS approach with component-based organization:

#### Variables (`common/variables.css`)
- **Colors**: Primary, secondary, success, error, warning, info, grays
- **Spacing**: Consistent spacing scale (xs to 3xl)
- **Typography**: Font sizes, weights, line heights
- **Shadows**: Box shadows for depth
- **Transitions**: Animation timing functions
- **Borders**: Border radius utilities
- **Z-index**: Layering management

#### Layout (`common/layout.css`)
- **Containers**: Responsive container widths (sm to 2xl)
- **Flexbox**: Flex utilities for alignment and distribution
- **Grid**: CSS Grid system for layouts
- **Display**: Block, inline, hidden utilities
- **Responsive**: Mobile-first breakpoints

#### Components
Each component has dedicated styles:
- Buttons: 6 variants × 3 sizes
- Forms: All input types with states
- Cards: Container component with variants
- Header: Navigation styling and responsiveness
- Sidebar: Menu styles and active states
- Tables: Multiple table variants
- Modals: Dialogs with animations

### Color Palette

```
Primary:      #1b5e20 (Dark Green)
Primary Dark: #0d3817
Primary Light: #4caf50

Secondary:    #6b4423 (Dark Brown)
Error:        #b00020 (Red)
Success:      #4caf50 (Green)
Warning:      #ffa726 (Orange)
Info:         #29b6f6 (Blue)

Border:       #e9ecef (Light Gray)
Text Dark:    #212529
Text Light:   #6c757d
```

## JavaScript Utilities

The `public/js/common.js` file provides reusable utilities:

### Storage Management
```javascript
storage.set('key', value);        // Save to localStorage
storage.get('key');               // Retrieve from localStorage
storage.remove('key');            // Remove from localStorage
```

### Session Management
```javascript
session.isAuthenticated();        // Check if user is logged in
session.getUser();                // Get current user info
session.setAuth(token, user);     // Set authentication
session.logout();                 // Clear session and redirect
```

### API Requests
```javascript
api.get('/endpoint');             // GET request
api.post('/endpoint', data);      // POST request
api.put('/endpoint', data);       // PUT request
api.delete('/endpoint');          // DELETE request
```

### DOM Utilities
```javascript
dom.query(selector);              // querySelector
dom.queryAll(selector);           // querySelectorAll
dom.create(tag, attrs, content);  // Create element
dom.show/hide/toggle(element);    // Show/hide element
dom.addClass/removeClass(element, class);
```

### Notification System
```javascript
notify.success('Success message');
notify.error('Error message');
notify.warning('Warning message');
notify.info('Info message');
```

### Validation
```javascript
validate.email(email);            // Email validation
validate.phone(phone);            // Phone validation
validate.url(url);                // URL validation
validate.required(value);         // Required field
validate.minLength(value, 6);     // Minimum length
```

## Component Usage Examples

### Alert Modal
```javascript
// Simple alert
AlertModal.show({
    title: 'Success',
    message: 'Operation completed',
    type: 'success'
});

// Confirmation dialog
AlertModal.confirm(
    'Are you sure?',
    'Confirm Action',
    () => console.log('Confirmed'),
    () => console.log('Cancelled')
);
```

### Data Grid
```javascript
DataGrid.init({
    title: 'Users',
    columns: [
        { key: 'id', label: 'ID', sortable: true },
        { key: 'name', label: 'Name', sortable: true },
        { key: 'email', label: 'Email', sortable: true }
    ],
    data: [
        { id: 1, name: 'John', email: 'john@example.com' },
        { id: 2, name: 'Jane', email: 'jane@example.com' }
    ],
    pageSize: 10
});
```

### Pagination
```javascript
Pagination.init({
    currentPage: 1,
    totalPages: 5,
    onPageChange: (page) => {
        console.log('Go to page', page);
    }
});
```

## Responsive Design

The frontend is built with mobile-first responsive design:

### Breakpoints
- **Mobile**: < 480px
- **Tablet**: 768px
- **Desktop**: 1024px+

All components scale appropriately at each breakpoint. The sidebar collapses on mobile, and tables become scrollable.

## Backend Integration

### API Endpoints
The frontend expects the following API endpoints:

```
POST   /api/auth/login        # User login
GET    /api/auth/me           # Get current user
POST   /api/auth/logout       # User logout

GET    /api/dashboard         # Dashboard data
GET    /api/farms             # Farm list
GET    /api/beneficiaries     # Beneficiary list
GET    /api/reports           # Reports list
```

### Authentication
- Token-based authentication (JWT)
- Token stored in localStorage as `auth_token`
- User data stored in localStorage as `auth_user`
- Automatic logout on token expiration

## Development Guidelines

### Adding New Pages

1. Create HTML file in `src/pages/`
2. Create CSS file in `public/css/pages/`
3. Import component CSS files at top of page CSS
4. Add navigation link in header and sidebar
5. Import layout and UI components as needed

### Adding New Components

1. Create HTML file in `src/components/` (layout or ui subfolder)
2. Include necessary CSS from `public/css/components/`
3. Add JavaScript logic if needed
4. Document usage in this README

### Styling Guidelines

- Use CSS variables from `common/variables.css`
- Follow BEM naming convention for CSS classes
- Keep component CSS self-contained
- Use flexbox and grid for layouts
- Test responsive design at all breakpoints

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance Optimization

- Minify CSS and JavaScript for production
- Optimize images (use WebP format where possible)
- Lazy load images and components
- Cache static assets
- Use CDN for external libraries

## Troubleshooting

### Page Not Loading
- Check browser console for errors (F12)
- Verify file paths are correct
- Ensure development server is running

### Styles Not Applying
- Clear browser cache (Ctrl+Shift+Del)
- Check CSS file imports
- Verify CSS variable definitions
- Use browser DevTools to inspect styles

### JavaScript Not Working
- Check console for errors
- Verify script file paths
- Ensure DOM is loaded before running JS
- Check browser JavaScript settings

## Resources

- [MDN Web Docs](https://developer.mozilla.org/)
- [CSS Tricks](https://css-tricks.com/)
- [JavaScript.info](https://javascript.info/)
- [Web.dev](https://web.dev/)

## License

Proprietary - Coffee Crop Monitoring System

## Support

For issues or questions:
- Email: support@coffee-monitoring.local
- Documentation: [Internal Wiki]
- Issues: [Issue Tracker]
