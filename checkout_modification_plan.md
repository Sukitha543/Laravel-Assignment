# Checkout Process Modification Plan (Final)

## 1. Database Modification
We will store shipping details in a separate table linked to the order.

### 1.1. Create Migration for Shipping Details
Create a new migration `create_order_shipping_details_table`.
- `order_id` (foreign key to `orders`, **onDelete('cascade')**)
- `name` (string)
- `email` (string)
- `address` (string)
- `city` (string)
- `phone` (string)

Command: `php artisan make:migration create_order_shipping_details_table`

### 1.2. Create ShippingDetail Model
Create `App\Models\OrderShippingDetail`.
- `fillable`: `['order_id', 'name', 'email', 'address', 'city', 'phone']`
- Relationship: `belongsTo(Order::class)`

### 1.3. Update Order Model
Update `App\Models\Order`.
- Relationship: `hasOne(OrderShippingDetail::class)`
- Ensure `hasMany(OrderItem)` also cascades on delete (usually handled by DB foreign key, but good to verify).

## 2. Routes
Update `routes/web.php`:
- `GET /checkout`: To display the checkout form (shipping details + cart summary).
- `POST /checkout/process`: To handle the form submission, create order + shipping details, and initiate Stripe.
- *Existing* `GET /checkout/success`: Remains for Stripe callback.
- *Existing* `GET /checkout/cancel`: Remains.

## 3. Controller Logic (`CheckoutController`)

### 3.1. New Method: `index()`
- Retrieve the authenticated user.
- Get the user's cart items.
- Calculate total price.
- Return `checkout.index` view with user, cartItems, and totalPrice.

### 3.2. Update Method: `checkout(Request $request)` (renamed to `process`)
- **Validation**: Validate shipping inputs.
- **Order Creation**:
  - Create `Order` (status: 'pending').
  - Create `OrderItems`.
  - **Create Shipping Detail**: Create a record in `order_shipping_details` linked to this order.
- **Stripe Integration**:
  - Create Stripe Session (pass `order_id` in metadata).
  - Update `Order` with `session_id`.
  - **Cancel URL Update**: Set `cancel_url` to `route('checkout.cancel', ['order_id' => $order->id])`.
- **Redirect**: Redirect to Stripe URL.

### 3.3. Update Method: `cancel(Request $request)`
- Retrieve `order_id` from request.
- If `order_id` exists:
  - Find the Order.
  - Check if status is 'pending' (safety check).
  - **Delete the Order**. (This will cascade delete items and shipping details).
- Return the cancel view (or redirect to cart with a message "Order cancelled").

## 4. Views

### 4.1. Create `resources/views/checkout/index.blade.php`
- Form for shipping details (Name, Email, Phone, Address, City).
- Cart Summary (Items, Total).
- Submit button ("Pay with Stripe").

### 4.2. Update `resources/views/cart/index.blade.php`
- Update "Proceed to Checkout" button to link to `route('checkout.index')`.

## 5. Execution Steps
1. Create Migration & Model for Shipping Details.
2. Update Order Model relationships.
3. Define Routes.
4. Create View (`checkout/index.blade.php`).
5. Update Controller Logic.
6. Update Cart View.
7. Test.
