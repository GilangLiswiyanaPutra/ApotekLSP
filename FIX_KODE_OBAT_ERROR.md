# Fix for MySQL Error: Incorrect integer value for kode_obat

## Problem
The error occurs because the `detail_penjualans` table has `kode_obat` column defined as `integer`, but the application is trying to insert string values like 'OBT-9KUHFH'.

**Error Message:**
```
SQLSTATE[22007]: Invalid datetime format: 1366 Incorrect integer value: 'OBT-9KUHFH' for column `apotek-lsp`.`detail_penjualans`.`kode_obat` at row 1
```

## Root Cause
The migration file shows `kode_obat` as `string`, but the actual database table still has it as `integer`. This can happen if:
1. The migration was not run after the fix
2. The database was created before the fix was applied
3. Manual database changes were made

## Solution

### Step 1: Apply the Column Type Migration
A new migration has been created to fix the column type:

**File:** `database/migrations/2025_07_29_180627_alter_detail_penjualans_kode_obat_to_string.php`

This migration will:
- Change `kode_obat` column from `integer` to `string`
- Allow rollback if needed

### Step 2: Run the Migration
```bash
# Check current migration status
php artisan migrate:status

# Run the new migration
php artisan migrate

# If you get connection errors, check your database configuration in .env
```

### Step 3: Alternative Solutions (if migration fails)

#### Option A: Fresh Migration (CAUTION: Will delete all data)
```bash
php artisan migrate:fresh --force
```

#### Option B: Manual Database Fix
If you have access to MySQL directly:
```sql
USE `apotek-lsp`;
ALTER TABLE `detail_penjualans` MODIFY COLUMN `kode_obat` VARCHAR(255) NOT NULL;
```

#### Option C: Recreate the Table
```sql
-- Backup existing data (if any)
CREATE TABLE detail_penjualans_backup AS SELECT * FROM detail_penjualans;

-- Drop and recreate table
DROP TABLE detail_penjualans;
CREATE TABLE detail_penjualans (
    nota VARCHAR(50) NOT NULL,
    kode_obat VARCHAR(255) NOT NULL,
    jumlah INT NOT NULL,
    INDEX idx_nota (nota),
    INDEX idx_kode_obat (kode_obat)
);

-- Restore data (if needed)
-- INSERT INTO detail_penjualans SELECT * FROM detail_penjualans_backup;
```

## Files Modified
1. `database/migrations/2025_07_29_180627_alter_detail_penjualans_kode_obat_to_string.php` (NEW)
2. Updated `.env` to use MySQL configuration

## Verification Steps

### 1. Check Database Configuration
Verify your `.env` file has correct MySQL settings:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apotek-lsp
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Test the Fix
After applying the migration, test by creating a transaction with medicine codes like 'OBT-9KUHFH'.

### 3. Verify Column Type
```sql
DESCRIBE detail_penjualans;
```
The `kode_obat` column should show as `varchar(255)` or similar string type.

## Important Notes

1. **Backup First**: Always backup your database before making structural changes
2. **Data Loss Warning**: `migrate:fresh` will delete all data
3. **Foreign Keys**: Ensure the `kode_obat` values in `detail_penjualans` match existing values in the `obats` table
4. **Application Restart**: You may need to restart your application server after the migration

## Prevention
To prevent this issue in the future:
1. Always run `php artisan migrate:status` to check if all migrations are applied
2. Use consistent data types across related tables
3. Test database operations after any schema changes

## Testing
After applying the fix, test with this sample data:
```php
// This should work without errors
DetailPenjualan::create([
    'nota' => 'PJ.20250729.0001',
    'kode_obat' => 'OBT-9KUHFH',
    'jumlah' => 1
]);
```