# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Expert system web application for calculating BMI, BMR, TDEE and providing personalized health recommendations based on user input.

## Setup Commands

```bash
# Initial setup (install deps, generate key, run migrations, build assets)
composer run setup

# Development server
composer run dev

# Run tests
composer run test

# Run a single test file
php artisan test tests/Unit/ExampleTest.php
```

## Architecture

### Core Services
- **`app/Services/ExpertSystemService.php`** — All calculation logic in one static service class:
  - `calculateBMI()` — Weight(kg) / Height(m)²
  - `classifyBMI()` — WHO classification (Kurus/Normal/Overweight/Obesitas)
  - `calculateBMR()` — Mifflin-St Jeor equation
  - `calculateTDEE()` — BMR × activity multiplier
  - `calculateRecommendedCalories()` — TDEE adjusted by goal
  - `generateRecommendations()` — Rule-based health recommendations
  - `processCalculation()` — Orchestrates all calculations, returns full data array

### Controllers
- **`app/Http/Controllers/CalculationController.php`** — Single controller handling:
  - `index` — Form page
  - `store` — Validate input, run ExpertSystemService, save Calculation, redirect
  - `result` — Display results
  - `history` — Paginated list of all calculations
  - `exportPdf` — Generate PDF via DomPDF
  - `destroy` — Delete calculation

### Routes (`routes/web.php`)
```
GET  /              → index (form)
POST /calculate    → store
GET  /result/{id}  → result
GET  /history      → history
GET  /export/pdf/{id} → exportPdf
DELETE /destroy/{id} → destroy
```

### Models
- **`app/Models/Calculation.php`** — Eloquent model with static label arrays and accessor methods for `activityLabel`, `goalLabel`, `genderLabel`.

### Database
- SQLite default (switch to MySQL via `.env` `DB_CONNECTION=mysql`)
- Single table: `calculations` — stores all input, calculated values, and generated recommendations

### Frontend
- Blade templates in `resources/views/calculations/`
- Tailwind CSS v4 via Vite (`vite.config.js`)
- PDF template: `resources/views/calculations/pdf.blade.php`

## Key Implementation Details

- Form validation is inline in `CalculationController::store()` — no separate Form Request class
- ExpertSystemService is entirely static (no dependency injection)
- Recommendations are generated as Indonesian text using rule-based matching on BMI classification, activity level, goal, and age
- Activity multipliers: sedenter=1.2, ringan=1.375, sedang=1.55, berat=1.725, atlet=1.9
- Calorie adjustments: maintain=0, lose=-500, gain=+500
