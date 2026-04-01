# Sistem Pakar Perhitungan Berat Badan & Kebutuhan Kalori

## Overview
Expert system web application for calculating BMI, BMR, TDEE and providing personalized health recommendations based on user input.

## Tech Stack
- **Backend**: Laravel 13 (PHP 8.2+)
- **Database**: SQLite (can be switched to MySQL in production)
- **Frontend**: Tailwind CSS v4 (via Vite)
- **PDF**: barryvdh/laravel-dompdf

## Features

### 1. Input Form
- Nama (text, required)
- Umur (integer, 1-120, required)
- Jenis Kelamin (radio: Laki-laki / Perempuan, required)
- Berat Badan (decimal, kg, required)
- Tinggi Badan (decimal, cm, required)
- Tingkat Aktivitas (select, required):
  - Sedenter (Jarang olahraga)
  - Ringan (Olahraga 1-3 hari/minggu)
  - Sedang (Olahraga 3-5 hari/minggu)
  - Berat (Olahraga 6-7 hari/minggu)
  - Atlet (Olahraga 2x/hari)
- Tujuan (select, required):
  - Maintain (Menjaga berat badan)
  - Lose Weight (Menurunkan berat badan)
  - Gain Weight (Menambah berat badan)

### 2. Expert System Logic

#### BMI Calculation & WHO Classification
```
BMI = Berat(kg) / (Tinggi(m))^2
```
- < 18.5: Kurus (Underweight)
- 18.5 - 24.9: Normal
- 25.0 - 29.9: Overweight
- >= 30.0: Obesitas (Obesity)

#### BMR Calculation (Mifflin-St Jeor)
```
Male:   BMR = 10 × Berat(kg) + 6.25 × Tinggi(cm) - 5 × Umur + 5
Female: BMR = 10 × Berat(kg) + 6.25 × Tinggi(cm) - 5 × Umur - 161
```

#### TDEE Calculation
```
TDEE = BMR × Activity Multiplier
```
Activity Multipliers:
- Sedenter: 1.2
- Ringan: 1.375
- Sedang: 1.55
- Berat: 1.725
- Atlet: 1.9

#### Calorie Recommendations
- Maintain: TDEE calories
- Lose Weight: TDEE - 500 kcal
- Gain Weight: TDEE + 500 kcal

### 3. Results Display
- BMI value with color-coded classification
- BMR value
- TDEE value
- Recommended daily calories
- Personalized recommendations based on:
  - BMI classification
  - Goal selection
  - Activity level

### 4. History & Export
- Save all calculations to MySQL database
- View calculation history
- Export individual result to PDF with:
  - User details
  - All calculated values
  - Recommendations
  - Date of analysis

## Database Schema

### Table: calculations
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| nama | varchar(255) | User name |
| umur | int | Age |
| jenis_kelamin | enum('laki', 'perempuan') | Gender |
| berat_badan | decimal(5,2) | Weight in kg |
| tinggi_badan | decimal(5,2) | Height in cm |
| tingkat_aktivitas | enum('sedenter', 'ringan', 'sedang', 'berat', 'atlet') | Activity level |
| tujuan | enum('maintain', 'lose', 'gain') | Goal |
| bmi | decimal(5,2) | Calculated BMI |
| klasifikasi_bmi | varchar(50) | BMI classification |
| bmr | decimal(7,2) | Basal Metabolic Rate |
| tdee | decimal(7,2) | Total Daily Energy Expenditure |
| kalori_rekomendasi | decimal(7,2) | Recommended daily calories |
| rekomendasi | text | AI-generated recommendations |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

## Pages

### 1. Home / Calculator Form (`/`)
- Hero section with app title
- Input form with all required fields
- Submit button to calculate

### 2. Results Page (`/result/{id}`)
- Display all calculation results
- Detailed recommendations
- Export to PDF button
- Back to home button

### 3. History Page (`/history`)
- List of all past calculations
- Date, name, BMI, classification
- View details link
- Export PDF link
- Delete option

## Acceptance Criteria
- [x] Form validates all inputs
- [x] BMI calculation matches WHO standards
- [x] BMR uses correct Mifflin-St Jeor formula
- [x] TDEE correctly applies activity multipliers
- [x] Recommendations are personalized based on all factors
- [x] Calculations saved to database
- [x] PDF export generates valid, styled document
- [x] History page shows all past calculations
- [x] UI is responsive and clean with Tailwind CSS
- [x] Application works with SQLite database (MySQL-ready)
