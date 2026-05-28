package com.example.model

enum class OrderState(val displayName: String) {
    PENDING("Pending"),
    COOKING("Cooking"),
    READY("Ready"),
    COMPLETED("Completed")
}

data class Product(
    val id: String,
    val name: String,
    val description: String,
    val price: Double,
    val category: String, // "Makanan", "Minuman", "Snack", "Dessert"
    val imageUrl: String,
    val isBestSeller: Boolean = false
)

data class CartItem(
    val product: Product,
    var quantity: Int,
    var notes: String = ""
)

data class Order(
    val id: String,
    val orderNo: String,
    val tableNo: String,
    val items: List<CartItem>,
    val state: OrderState,
    val isTakeaway: Boolean = false,
    val estimatedMinutes: Int = 12,
    val totalAmount: Double,
    val timestamp: String,
    val timestampMillis: Long = System.currentTimeMillis()
)

data class Transaction(
    val orderNo: String,
    val destination: String, // "Table 12", "Takeaway"
    val status: String, // "Completed", "Preparing"
    val amount: Double,
    val time: String
)

data class RestockItem(
    val id: String,
    val name: String,
    val unit: String,
    val currentAmount: Double,
    val goalAmount: Double,
    val imageUrl: String
)
