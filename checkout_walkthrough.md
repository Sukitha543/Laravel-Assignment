# Stripe Checkout Implementation Plan

This document outlines the steps to implement Stripe Checkout functionality for the application.

## 1. Prerequisites
- **Stripe Package**: `stripe/stripe-php` is already installed.
- **Environment Keys**: `STRIPE_KEY` and `STRIPE_SECRET` should be in `.env`.

## 2. Database & Models
We need to handle Orders and Order Items.

### 2.1. Create Models & Migrations
Run the following commands:
```bash
php artisan make:model Order -m
php artisan make:model OrderItem -m
```

### 2.2. Order Migration
Update `create_orders_table.php` to include:
- `user_id` (foreign key)
- `total_price` (decimal)
- `status` (string, default: 'pending')
- `session_id` (string, nullable) - to store Stripe Session ID
- `timestamps`

### 2.3. OrderItem Migration
Update `create_order_items_table.php` to include:
- `order_id` (foreign key)
- `product_id` (foreign key)
- `quantity` (integer)
- `price` (decimal) - snapshot of price at time of order
- `timestamps`

### 2.4. Model Relationships
- **Order**: `belongsTo(User)`, `hasMany(OrderItem)`
- **OrderItem**: `belongsTo(Order)`, `belongsTo(Product)`
- **User**: `hasMany(Order)`

## 3. Stripe Checkout Workflow

### 3.1. CheckoutController
Create `CheckoutController`:
```bash
php artisan make:controller CheckoutController
```

Implement 3 methods:
1.  **`checkout()`**:
    - Retrieve user's cart items.
    - Calculate total.
    - **Create Order** record with status `pending`.
    - Create `OrderItems` from cart.
    - Initialize Stripe Session using `\Stripe\Checkout\Session::create`.
        - Pass line items (from cart).
        - Set `mode` to `payment`.
        - Set `success_url` to `route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}'`.
        - Set `cancel_url` to `route('checkout.cancel')`.
        - Set `metadata` with `order_id`.
    - Redirect to `session->url`.

2.  **`success(Request $request)`**:
    - Retrieve `session_id` from query string.
    - Verify session with Stripe.
    - If paid:
        - Update **Order** status to `paid` (or `completed`).
        - **Reduce Stock**: Loop through order items and decrement product quantity.
        - **Clear Cart**: Remove user's cart items.

        - Return view `checkout.success`.

3.  **`cancel()`**:
    - Return view `checkout.cancel` (Simple error/cancellation message).

## 4. Views & Routes

### 4.1. Routes (`routes/web.php`)
Authenticated routes group:
```php
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
```

### 4.2. Views
- **`cart/index.blade.php`**: Add a form with a "Proceed to Checkout" button allowed only if cart is not empty.
- **`checkout/success.blade.php`**: Success message.
- **`checkout/cancel.blade.php`**: Error/Cancel message.



## 6. Execution Steps
1. Create Database Tables.
2. Define Routes.
3. Implement Controller Logic.
4. Create Views.

6. Test.


