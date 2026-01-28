# Stock Reservation Implementation Plan

## Objective
Reduce product stock **before** redirecting the user to Stripe (reservation). If the user cancels or the payment fails, the stock must be restored (released).

## 1. Controller Logic Update (`CheckoutController` & `Api\CheckoutController`)

### 1.1. Enhance `process()` / `checkout()` (Reservation)
- **Current Flow**: Check stock -> Create Pending Order -> Redirect.
- **New Flow**:
  1.  Start Database Transaction.
  2.  Check Stock.
  3.  **Reduce Stock**: Immediate subtraction from product quantity.
  4.  Create Pending Order.
  5.  Commit Transaction.
  6.  Redirect to Stripe.

### 1.2. Update `success()` (Confirmation)
- **Current Flow**: Reduce stock here.
- **New Flow**:
  - Remove the stock reduction logic.
  - Just mark order as `paid`.
  - Clear the cart.

### 1.3. Update `cancel()` (Restoration)
- **Current Flow**: Deletes order (but doesn't touch stock).
- **New Flow**:
  1.  Find the pending order by ID.
  2.  **Restore Stock**: Loop through order items and add the quantity back to the products.
  3.  Delete the order (or mark as cancelled).
  4.  Show cancel page.

## 2. Handling Edge Cases (Abandoned Carts)
*Problem*: If a user closes the tab instead of clicking "Cancel", the stock remains reserved forever (stuck in "pending" order).
*Solution*: A cleanup mechanism is strictly required.

### 2.1. Create a Scheduled Command
- Create a comprehensive command `php artisan orders:cleanup`.
- Logic:
  - Find orders that are `pending` AND created > X minutes ago (e.g., 30 mins).
  - For each:
    - Loop through items and **restore stock**.
    - expire/delete the order.

### 2.2. Schedule the Command
- Register in `routes/console.php` or `app/Console/Kernel.php` to run every minute/hour.

## 3. Execution Steps
1.  **Refactor `process` method**: Move stock reduction here.
2.  **Refactor `success` method**: Remove stock reduction.
3.  **Refactor `cancel` method**: Add stock restoration.
4.  *(Optional but Recommended)*: Create Cleanup Command to handle abandoned sessions.

Note: I will apply these changes to both the Web `CheckoutController` and the `Api\CheckoutController`.
