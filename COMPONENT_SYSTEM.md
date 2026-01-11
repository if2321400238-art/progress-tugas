# Progress Tugas - Component System Documentation

## 🎯 Struktur Layout Terbaru

Sistem layout telah sepenuhnya di-refactor menggunakan **Laravel Blade Components** untuk lebih modular, reusable, dan maintainable.

## 📁 Component Architecture

### Folder Struktur
```
resources/views/
├── components/              # ← Semua reusable components
│   ├── header.blade.php
│   ├── footer.blade.php
│   ├── quote-banner.blade.php
│   ├── search-bar.blade.php
│   ├── task-card.blade.php
│   ├── task-card-completed.blade.php
│   └── empty-state.blade.php
│
├── layouts/
│   └── app.blade.php        # ← Main layout dengan components
│
└── tugas/
    ├── index.blade.php      # ← Refined dengan components
    ├── selesai.blade.php    # ← Refined dengan components
    ├── create.blade.php
    └── edit.blade.php
```

## 🧩 Component Details

### 1. **Header** (`<x-header />`)
**File**: `resources/views/components/header.blade.php`

**Fitur**:
- Logo & branding
- Desktop navigation menu
- Notifikasi dropdown
- User profile menu
- Mobile menu toggle
- Responsive design

**Penggunaan**:
```blade
<x-header />
```

---

### 2. **Footer** (`<x-footer />`)
**File**: `resources/views/components/footer.blade.php`

**Fitur**:
- Company information
- Quick links
- Contact information
- Social media links
- Mobile bottom navigation (sticky)
- Copyright section

**Penggunaan**:
```blade
<x-footer />
```

---

### 3. **Quote Banner** (`<x-quote-banner />`)
**File**: `resources/views/components/quote-banner.blade.php`

**Fitur**:
- Beautiful gradient background
- Auto-rotating quotes (every 8 seconds)
- Manual refresh button
- Smooth fade transitions
- Inspirational quotes collection

**Penggunaan**:
```blade
<x-quote-banner />
```

**Quote Array** (dalam component):
```php
$quotes = [
    "Kesuksesan adalah perjalanan...",
    "Jangan menunda apa yang bisa...",
    // ... lebih banyak quotes
];
```

---

### 4. **Search Bar** (`<x-search-bar />`)
**File**: `resources/views/components/search-bar.blade.php`

**Fitur**:
- Real-time search filtering
- Search dropdown dengan hasil
- Clear button
- Data attributes support (data-task-name, data-task-subject)
- Enter key support
- Mobile responsive

**Penggunaan**:
```blade
<x-search-bar />
```

**Cara Kerja**:
- Filters by task name dan subject
- Direct card visibility toggling
- Dropdown shows matching results

---

### 5. **Task Card** (`<x-task-card :tugas="$tugas" />`)
**File**: `resources/views/components/task-card.blade.php`

**Props**:
- `$tugas` - Array data tugas (nama, matkul, kesulitan, deadline, etc)
- `$index` - Optional index untuk looping

**Fitur**:
- Colored header (Mudah=Green, Sedang=Yellow, Sulit=Red)
- Task information (nama, subject, difficulty)
- Deadline display
- Progress bar (0-100%)
- "Selesai" button (emerald gradient)
- Dropdown menu (Edit/Delete)
- Data attributes for search

**Penggunaan**:
```blade
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-max">
    @foreach($tugasArray as $index => $tugas)
        <x-task-card :tugas="$tugas" :index="$index" />
    @endforeach
</div>
```

---

### 6. **Task Card Completed** (`<x-task-card-completed :tugas="$tugas" />`)
**File**: `resources/views/components/task-card-completed.blade.php`

**Props**: Same as task-card

**Fitur**:
- Fixed green gradient header
- "Kembalikan" button (revert to pending)
- Full progress bar (100%)
- Same dropdown menu
- Data attributes for search

**Penggunaan**:
```blade
<x-task-card-completed :tugas="$tugas" :index="$index" />
```

---

### 7. **Empty State** (`<x-empty-state />`)
**File**: `resources/views/components/empty-state.blade.php`

**Props**:
- `$title` - Main heading
- `$message` - Description text
- `$actionText` - Button text (optional)
- `$actionUrl` - Button URL (optional)
- `$icon` - Icon type: 'document', 'check', 'search', 'bell'

**Penggunaan**:
```blade
<x-empty-state 
    title="Belum Ada Tugas"
    message="Mulai tambahkan tugas Anda"
    actionText="Buat Tugas"
    actionUrl="{{ route('tugas.create') }}"
    icon="document" />
```

---

## 📄 Main Layout (`app.blade.php`)

**File**: `resources/views/layouts/app.blade.php`

**Struktur**:
```blade
<!DOCTYPE html>
<html>
<head>
    <!-- Meta tags, CSRF, Vite -->
</head>
<body>
    @auth
        <x-header />
        <main class="max-w-7xl mx-auto px-4 py-8">
            @yield('content')
        </main>
        <x-footer />
    @endauth
    
    @guest
        <!-- Login/Register layout -->
    @endguest
</body>
</html>
```

**Keuntungan**:
- Clean, maintainable structure
- Konsisten header/footer di semua halaman
- Mudah di-customize
- Responsive design built-in

---

## 📋 Page: Index (Dashboard)

**File**: `resources/views/tugas/index.blade.php`

**Struktur**:
```blade
@extends('layouts.app')

<div class="welcome-section">
    <!-- Title & Create button -->
</div>

<x-quote-banner />
<x-search-bar />

<div class="grid auto-rows-max">
    @foreach($tugasArray as $tugas)
        <x-task-card :tugas="$tugas" />
    @endforeach
</div>
```

**Fitur**:
- Auto-rotating quotes
- Real-time search
- Card grid dengan auto-rows-max (fix stacking)
- Empty state untuk no data
- Mobile responsive

---

## 📋 Page: Selesai (Completed Tasks)

**File**: `resources/views/tugas/selesai.blade.php`

**Struktur**:
```blade
@extends('layouts.app')

<div class="grid auto-rows-max">
    @foreach($tugasSelesai as $tugas)
        <x-task-card-completed :tugas="$tugas" />
    @endforeach
</div>
```

**Fitur**:
- Displays completed tasks (100% progress)
- Back button to continue tasks
- Same component system
- Empty state untuk no data

---

## 🎨 Design System

### Colors
- **Primary**: Emerald (#10B981)
- **Secondary**: Teal (#14B8A6)
- **Accent**: Cyan, Blue
- **Neutral**: Gray scale

### Spacing
- `gap-6` for grid gaps
- `p-4 md:p-8` for section padding
- `rounded-2xl` for card borders
- `shadow-soft-lg` for subtle shadows

### Typography
- **Headings**: `font-bold text-gray-900`
- **Subheadings**: `font-semibold text-gray-600`
- **Body**: `text-gray-700`

### Responsive Breakpoints
- `sm`: 640px
- `md`: 768px
- `lg`: 1024px
- `xl`: 1280px

---

## 🔧 How to Use Components

### Creating New Pages

**Example: New Feature Page**
```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold">Feature Title</h2>
    </div>

    <!-- Use components -->
    <x-quote-banner />
    <x-search-bar />

    <!-- Your content -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-max">
        <!-- Cards here -->
    </div>
@endsection
```

### Creating New Components

**Step 1**: Create file in `resources/views/components/`
```blade
<!-- resources/views/components/my-component.blade.php -->
@props(['title', 'description'])

<div class="bg-white rounded-2xl shadow-soft-lg p-6">
    <h3 class="font-bold">{{ $title }}</h3>
    <p>{{ $description }}</p>
</div>
```

**Step 2**: Use in templates
```blade
<x-my-component title="Hello" description="World" />
```

---

## 🐛 Fixes Applied

### Card Stacking Issue ✅
**Problem**: Cards were overlapping/bertumpuk
**Solution**: Added `auto-rows-max` to grid
```blade
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 auto-rows-max">
```

### Search Not Working ✅
**Problem**: `card.parentElement.style.display` hiding grid wrapper
**Solution**: Changed to `card.style.display` targeting individual cards

### Mobile Modal Blocking ✅
**Problem**: Search modal `fixed inset-0` covered entire screen
**Solution**: Changed to `fixed inset-x-0 top-0` (top bar only)

---

## 📱 Responsive Features

### Mobile
- Bottom navigation (footer component)
- Hamburger menu in header
- Full-width cards (1 column)
- Touch-friendly buttons

### Tablet
- 2-column grid layout
- Side navigation visible
- Optimized spacing

### Desktop
- 3-column grid layout
- Full sidebar
- Horizontal navigation
- Max-width container (7xl)

---

## 🚀 Next Steps

1. **Test all pages** - Verify components render correctly
2. **Update remaining pages** - Apply same component system to create/edit pages
3. **Add more components** - Button groups, badge system, etc.
4. **Optimize performance** - Lazy loading, code splitting
5. **Add animations** - Entrance, transitions for components
6. **Documentation** - Add Storybook for component showcase

---

## 📞 Support

Untuk pertanyaan atau issues dengan component system:
1. Check component file untuk prop definitions
2. Review index.blade.php untuk usage examples
3. Inspect HTML output untuk styling issues
4. Check browser console untuk JavaScript errors

---

**Last Updated**: January 2026
**Version**: 2.0 (Component-based System)
