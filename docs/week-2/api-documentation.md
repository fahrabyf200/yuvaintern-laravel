# Product Management API Documentation

## 1. API Overview

This API is part of the Product Management System developed using Laravel. The API provides RESTful endpoints for managing product data.

The Product API supports the following operations:

* Retrieve all products
* Retrieve a single product
* Create a new product
* Update an existing product
* Delete a product

The API uses JSON for request and response data.

## 2. Base URL

For local development, the API uses:

```text
http://127.0.0.1:8000/api
```

All product endpoints use the `/products` path.

## 3. API Endpoints

### 3.1 Get All Products

**Method:**

```text
GET
```

**Endpoint:**

```text
/api/products
```

**Purpose:**

Retrieve all products from the database.

**Example Request:**

```text
GET http://127.0.0.1:8000/api/products
```

**Example Response:**

```json
{
    "success": true,
    "message": "Products retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": "Gaming Mouse",
            "description": "Wireless gaming mouse",
            "price": "350000.00",
            "stock": 20,
            "category": {
                "id": 1,
                "name": "Electronics"
            }
        }
    ]
}
```

**HTTP Status:**

```text
200 OK
```

---

### 3.2 Get Product by ID

**Method:**

```text
GET
```

**Endpoint:**

```text
/api/products/{product}
```

**Purpose:**

Retrieve a specific product using its ID.

**Example Request:**

```text
GET http://127.0.0.1:8000/api/products/1
```

**HTTP Status:**

```text
200 OK
```

If the product does not exist, Laravel returns:

```text
404 Not Found
```

---

### 3.3 Create Product

**Method:**

```text
POST
```

**Endpoint:**

```text
/api/products
```

**Purpose:**

Create a new product in the database.

**Required Headers:**

```text
Accept: application/json
Content-Type: application/json
```

**Request Body:**

```json
{
    "category_id": 1,
    "name": "Gaming Mouse",
    "description": "Wireless gaming mouse",
    "price": 350000,
    "stock": 20
}
```

**Validation Rules:**

* `category_id` is required and must exist in the categories table.
* `name` is required and must be a string.
* `description` is optional.
* `price` is required and must be numeric with a minimum value of 0.
* `stock` is required and must be an integer with a minimum value of 0.

**Successful Response:**

```text
201 Created
```

**Example Response:**

```json
{
    "success": true,
    "message": "Product created successfully",
    "data": {
        "id": 1,
        "name": "Gaming Mouse",
        "description": "Wireless gaming mouse",
        "price": "350000.00",
        "stock": 20,
        "category": {
            "id": 1,
            "name": "Electronics"
        }
    }
}
```

---

### 3.4 Update Product

**Method:**

```text
PUT
```

**Endpoint:**

```text
/api/products/{product}
```

**Purpose:**

Update an existing product.

**Example Request:**

```text
PUT http://127.0.0.1:8000/api/products/1
```

**Request Body:**

```json
{
    "category_id": 1,
    "name": "Gaming Mouse RGB",
    "description": "Wireless RGB gaming mouse",
    "price": 400000,
    "stock": 15
}
```

**HTTP Status:**

```text
200 OK
```

---

### 3.5 Delete Product

**Method:**

```text
DELETE
```

**Endpoint:**

```text
/api/products/{product}
```

**Purpose:**

Delete an existing product from the database.

**Example Request:**

```text
DELETE http://127.0.0.1:8000/api/products/1
```

**Example Response:**

```json
{
    "success": true,
    "message": "Product deleted successfully"
}
```

**HTTP Status:**

```text
200 OK
```

If the product does not exist:

```text
404 Not Found
```

## 4. Validation and Error Handling

The API uses Laravel request validation to validate incoming product data.

For example, an invalid request:

```json
{
    "category_id": 999,
    "name": "",
    "price": -100,
    "stock": -5
}
```

returns:

```text
422 Unprocessable Content
```

The validation prevents invalid data from being stored in the database.

The API also uses Laravel Route Model Binding for product IDs. When a requested product cannot be found, Laravel automatically returns a `404 Not Found` response.

## 5. API Resource

The project uses `ProductResource` to control the structure of product responses.

The resource provides:

* Product ID
* Product name
* Product description
* Product price
* Product stock
* Related category ID
* Related category name

Using an API Resource makes the response structure more consistent and prevents the API from directly exposing the entire model structure.

## 6. Product and Category Relationship

A product belongs to one category.

The relationship is defined using Laravel Eloquent:

```php
public function category(): BelongsTo
{
    return $this->belongsTo(Category::class);
}
```

The API uses eager loading when retrieving products:

```php
Product::with('category')->get();
```

This allows the category information to be included in the API response.

## 7. HTTP Status Codes

The API uses standard HTTP status codes:

```text
200 OK
```

Used for successful GET, PUT, and DELETE requests.

```text
201 Created
```

Used when a new product is successfully created.

```text
404 Not Found
```

Used when the requested product does not exist.

```text
422 Unprocessable Content
```

Used when the submitted data fails validation.

## 8. Postman Testing

The Product API was tested using Postman.

The following operations were tested:

1. Get all products
2. Get product by ID
3. Create product
4. Update product
5. Delete product
6. Submit invalid product data
7. Request a non-existent product

The tests confirmed that the API routes, validation, database operations, response format, and HTTP status codes work as expected.

## 9. Automated Laravel Testing

Laravel's built-in testing system was also executed using:

```bash
php artisan test
```

The current project tests completed successfully:

```text
Tests:    2 passed (2 assertions)
Duration: 0.72s
```

The successful tests confirm that the existing Laravel application and feature tests are functioning correctly.

## 10. Postman Collection

A Postman collection was created for the Product Management API.

The collection contains the main Product API requests:

```text
Products
├── GET List Products
├── GET Get Product
├── POST Create Product
├── PUT Update Product
└── DELETE Delete Product
```

Additional testing requests can be included for validation errors and non-existent resources.

The Postman collection is included in the project repository as part of the Week 2 deliverables.
