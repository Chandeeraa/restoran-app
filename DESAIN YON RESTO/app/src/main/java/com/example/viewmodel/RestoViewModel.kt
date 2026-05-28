package com.example.viewmodel

import androidx.lifecycle.ViewModel
import com.example.model.*
import kotlinx.coroutines.flow.MutableStateFlow
import kotlinx.coroutines.flow.StateFlow
import kotlinx.coroutines.flow.asStateFlow
import java.text.SimpleDateFormat
import java.util.Date
import java.util.Locale

class RestoViewModel : ViewModel() {

    // List of predefined menu items
    val products = listOf(
        Product(
            id = "1",
            name = "Signature Poke Bowl",
            description = "Fresh salmon with avocado, edamame, and our special sesame dressing.",
            price = 65000.0,
            category = "Makanan",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuA7q59P5rooigMOz415YK0eN-lC9ZuR4qJZQNkM17PISWED9uRqd0y9SnZ9qQDVf6CjRqnHOD0gtzI89vG2vujDvSLxwcy4aaRHPN3yyme_RLsGCeTOsCMtZFMzX8zl48drC1n5w8bif2DuFhC_sdMfN_gg9hrTfvSwBuLUMWJ2DW93QmCpyLhATH9nvMeFQHpfU9YwTj5QYTmLiNndjMlUSi9l1-tWuKtaZ90IkdUUAaLDMqlKhtqmXaPWAXY6cBtnk_U6YW9yUzMB",
            isBestSeller = true
        ),
        Product(
            id = "2",
            name = "Wagyu Cheese Burger",
            description = "Premium wagyu beef patty, cheddar, and caramelized onions on brioche.",
            price = 88000.0,
            category = "Makanan",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuDu-q9u8MVuWYoSD1boEVM9-W2d3TdiECaCPSqhz0qpjQxelQy8mYWfKpOO4UcdFL-X8PyRg4KcVugJrzFs7mBD0V9MdkFlwIbG2VawGyLhFhx1qP5DVp_F-8HmzJrBYuUI9iW0jmEfNJU4CYK4hGFW9gAtkbFI98GxsTsP5L0n7LsXta_kJkS8up-yEuP5iHXHctOjDJdhwGJ-4vwrlOl3XKdtJWN9t3Gg3EAyprg1EYmY1VNtZGesfazlS9CbnBq8YUJhLWKmZy3d",
            isBestSeller = false
        ),
        Product(
            id = "3",
            name = "Tropical Iced Tea",
            description = "Refreshing brewed tea with lychee and wild mint leaves.",
            price = 25000.0,
            category = "Minuman",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuBcFeYcY8bYQWdYEP8Jig4-7PAbz-TSGGiEODjwl9jE-QQ_CX30HPUmwUR1AE47bdq7dyPyOUFDiw5OM5DjoyDlnenEpDAJYjUBQgdcqQrL6nrKMzxUDmgdZtdFfrMO-69PtnHgScfaaBu_Xg2CkFvk1gBATAND-CSe9oSJylyP3eb12PTefAfeKEF0mfA7trBPBl31Ig-l94Yu4ck8ljUzOMWKjhQRmafvLgf4Ty2XiZgKJGyMrCoYh5akAwm9_F8LFvlotnTRWAGN",
            isBestSeller = true
        ),
        Product(
            id = "4",
            name = "Margherita Artisan Pizza",
            description = "Stone-baked crust, organic tomato sauce, and fresh buffalo mozzarella.",
            price = 75000.0,
            category = "Makanan",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuBIQlh0fzOagPQO7B1tc8nXT8yIRfhWTo2TrZPTFJytEktmVQclwg4J650tFGsgqCKo0GKjz5e9I_X-yj0KJ2iqX-gyHJtSJFmL-jHoDKtf2ZtDg1GGzNvr1k-vxEbjDmA_FRhKNd72eKKuGDJLsi7emmEB4VfdyRoJiJkVvUK4Ye372g7yG2p96mwEeZrwimc2aOf61_eCVTrfavzdHbqYt0VZRtGmQo-_-0B6VIdSAHEpQMjGHu_Zr6s6xC9XU0t4E7EHonjIKEAc",
            isBestSeller = false
        ),
        Product(
            id = "5",
            name = "Salmon Mentai Rice",
            description = "Charred mentaiko sauce over salmon chunks, seaweed strips and white rice.",
            price = 55000.0,
            category = "Makanan",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuASH8Pd9uPZSZa2OU829Nfi-DWpcAT9AFpZoJE1b_yzWaiVqn9WH8Q3I1YKD4U0AXI-PpVxVKWn8gv-ejzAnhqWp5CEgOLef0-vkchfobKcuy11nzQ1eGjcJpkwt5bM7NVCF6WL-TXMVktyPg30CFzwZIcPv_oOjZQoj6YfK6ocQCh9bbE5q4SSBfqeHcslE3YTXKdW2fzlE0-w0FOEniVqnlcdICOzFI6A_X_uFrKFazESsrGR9Fkyk5gp-7XCRcK6VPBmg255eC4K",
            isBestSeller = false
        ),
        Product(
            id = "6",
            name = "Lychee Berries Fizz",
            description = "Floating fresh check berries and lychees in sparkling crystal-clear drink.",
            price = 32000.0,
            category = "Minuman",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuBdEfmBaRmu-SZoE9ci4mnjNTBU4A9ghRSwfuQJKOUUgAXxpMFBi5ILwMl94JOh56GO8YQ_HjKPjSLOy4euIipx5BfLuvmmAok0JOdXjoWuQDflyrkI8EsrViot71spzRTm93DPfyi_gtQ5udGxYsNf5LocSXcW9HM4lUU1vwPsUcC3cMJupw1O4RGjVMl_5LSviNTRy9FCxLq2ijdVbwZeX78IG07E04InahIe1oLvnUYQT0KsKMgI8iHSgTEJEnD6YGoBdMC9e-U1",
            isBestSeller = false
        ),
        Product(
            id = "7",
            name = "Nasi Goreng Spesial",
            description = "Vibrant Indonesian fried rice topped with a crispy sunny-side-up egg and cucumber slices.",
            price = 45000.0,
            category = "Makanan",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuD-6sf1-J1Yp3Cp_lhGCj13RvepgaRDiQygkkvFw7Q5bMh-DDgKGvwEfUYNIM8LO_fVnqHuA3Yves6Fl3OyXCNINHxb0NVjuYQ70kwIfVpREoKFToDYBX5sL2pWVHQL9zNzUNw3qFb2CXoVnlElquovYy3WLB9D2dh3aFPSnQufN3e3RRXqGlKH8Z-GgI8GYk_NqC0KqyQCACReQTg0DfMlQzZFmubAOMRwsQITi7bHixvTg3PerOue6sndT2h5cZ0h1HPG_BSeuuHH",
            isBestSeller = false
        ),
        Product(
            id = "8",
            name = "Es Teh Manis",
            description = "Standard ice sweetened jasmine tea on local wood platter with dew.",
            price = 12000.0,
            category = "Minuman",
            imageUrl = "https://lh3.googleusercontent.com/aida-public/AB6AXuChaZv-ZN5X-WwsJGtqD5rJTQlTlTNK2Z7btSHTSDdnajuFZohuvqOzA2QGGg4uUCVNK7pzpVywEIA6Vu4oLwHAWDkQCScmKjfsUo1hMiYY-lk7H8Qn31UJ777Gg22rhyWWxDbO1n0h8c9CEIl1abWBPTKFULtGwPbJRL_y53HrQd5klQ2ut79GSMQ7Oh8pwiBrCamc2WBA6a5tcUWAtHrBZIlRVyx6-KA4PIrpp2AyOVVSZkqI1eN83z3V_IlXz_8gSImgip8dJuh2",
            isBestSeller = false
        )
    )

    // Shopping Cart State
    private val _cartItems = MutableStateFlow<List<CartItem>>(emptyList())
    val cartItems = _cartItems.asStateFlow()

    // Active order lists (KDS viewable)
    private val _orders = MutableStateFlow<List<Order>>(emptyList())
    val orders = _orders.asStateFlow()

    // Track active customer order
    private val _trackedOrder = MutableStateFlow<Order?>(null)
    val trackedOrder = _trackedOrder.asStateFlow()

    // Table Context - Customer sits at Table 12 in mockup, POS sits at Table 08
    private val _currentTable = MutableStateFlow("12")
    val currentTable = _currentTable.asStateFlow()

    // Makan di Tempat (Dine-In) vs Bawa Pulang (Takeaway)
    private val _isDineIn = MutableStateFlow(true)
    val isDineIn = _isDineIn.asStateFlow()

    // Promo code applied
    private val _appliedPromoCode = MutableStateFlow<String?>(null)
    val appliedPromoCode = _appliedPromoCode.asStateFlow()

    private val _promoDiscountRate = MutableStateFlow(0.0)
    val promoDiscountRate = _promoDiscountRate.asStateFlow()

    // Call waiter alerts
    private val _isCallWaiterActive = MutableStateFlow(false)
    val isCallWaiterActive = _isCallWaiterActive.asStateFlow()

    // Low stock items states
    private val _restockItems = MutableStateFlow(listOf(
        RestockItem("s1", "Fresh Salmon Slices", "Kilograms", 1.2, 10.0, "https://lh3.googleusercontent.com/aida-public/AB6AXuD1i7RchsKynIN7ZygJSevM3NtZynXJ2pxiX1fw7GVMr2JlFpECJk5m2fEJoOfdGRxHJgea4Zi897xfMTBgfob6xYJKPBNDu69wCZt-Z5X7x9AnThMt0zdvwfO5KgtAAFSe726kL2mI4wZPSYycluPlAIUSiopwChvxuJURKigxxBTbhKAykpvc7UKYE6KB7lmsDFv1r9hn-YK5mvCk0-1B6T6uckzu_H6AkcZQQprxaXkL_LHGlvBogx63qoWoeCJPIGmxH8WpRboq"),
        RestockItem("a1", "Ripe Avocado (Hass)", "Pieces", 8.0, 40.0, "https://lh3.googleusercontent.com/aida-public/AB6AXuBW5LHz9A1Jp85F8flUayFlewAakLMZb3Apd-cO_dnxlO-PQB7saRcZsSfQS2E0SUqtvyHAJ5cQ49VsSkG0_Q8yKAA2nNGuB3G00RoGNimN25NGBVLBobot-IyhhU_Ijw4l2_O_UFSze-RNeq931jS1IEDUqIh6r8Vtnqp35tK8aa7knTVO-uP08TlKRQEq6K-SWPTtFkOQLVqWzSE3zYOk8FsUNkRc5s1-6p05qlPBQkQgSSdWppw4IqJRqZXSn0vco3EijeMW9AMy"),
        RestockItem("t1", "Truffle Oil Extra", "Liters", 0.5, 2.0, "https://lh3.googleusercontent.com/aida-public/AB6AXuBIQlh0fzOagPQO7B1tc8nXT8yIRfhWTo2TrZPTFJytEktmVQclwg4J650tFGsgqCKo0GKjz5e9I_X-yj0KJ2iqX-gyHJtSJFmL-jHoDKtf2ZtDg1GGzNvr1k-vxEbjDmA_FRhKNd72eKKuGDJLsi7emmEB4VfdyRoJiJkVvUK4Ye372g7yG2p96mwEeZrwimc2aOf61_eCVTrfavzdHbqYt0VZRtGmQo-_-0B6VIdSAHEpQMjGHu_Zr6s6xC9XU0t4E7EHonjIKEAc")
    ))
    val restockItems = _restockItems.asStateFlow()

    // Dynamic mock statistics
    private val _totalRevenue = MutableStateFlow(12450000.0)
    val totalRevenue = _totalRevenue.asStateFlow()

    private val _totalOrdersCount = MutableStateFlow(142)
    val totalOrdersCount = _totalOrdersCount.asStateFlow()

    private val _transactions = MutableStateFlow(listOf(
        Transaction("#ORD-9021", "Table 12", "Completed", 245000.0, "2 mins ago"),
        Transaction("#ORD-9020", "Takeaway", "Preparing", 112500.0, "15 mins ago"),
        Transaction("#ORD-9019", "Table 05", "Completed", 320000.0, "12:30 PM")
    ))
    val transactions = _transactions.asStateFlow()

    init {
        // Seed default orders in the kitchen (just like the KDS visual mockup) to start with
        val formattedTime = SimpleDateFormat("HH:mm", Locale.getDefault()).format(Date())
        _orders.value = listOf(
            Order(
                id = "ord_82",
                orderNo = "#ORD-082",
                tableNo = "12",
                items = listOf(
                    CartItem(products[0], 1, "Extra Furikake, Medium Rare"), // Signature Poke Bowl
                    CartItem(products[4], 2, "Spicy Vinegar on side")       // Salmon Mentai Rice
                ),
                state = OrderState.PENDING,
                isTakeaway = false,
                estimatedMinutes = 18,
                totalAmount = 141900.0,
                timestamp = "18:12"
            ),
            Order(
                id = "ord_85",
                orderNo = "#ORD-085",
                tableNo = "Grb",
                items = listOf(
                    CartItem(products[5], 3, "Less Ice, 50% Sugar") // Lychee Berries Fizz
                ),
                state = OrderState.PENDING,
                isTakeaway = true,
                estimatedMinutes = 6,
                totalAmount = 96000.0,
                timestamp = "06:45"
            ),
            Order(
                id = "ord_84",
                orderNo = "#ORD-084",
                tableNo = "05",
                items = listOf(
                    CartItem(products[4], 1), // Salmon Mentai Rice
                    CartItem(products[7], 1)  // Es Teh Manis
                ),
                state = OrderState.COOKING,
                isTakeaway = false,
                estimatedMinutes = 9,
                totalAmount = 67000.0,
                timestamp = "09:30"
            )
        )
    }

    // Cart Manipulators
    fun addToCart(product: Product, notes: String = "") {
        val current = _cartItems.value.toMutableList()
        val index = current.indexOfFirst { it.product.id == product.id }
        if (index != -1) {
            current[index] = current[index].copy(quantity = current[index].quantity + 1, notes = notes)
        } else {
            current.add(CartItem(product, 1, notes))
        }
        _cartItems.value = current
    }

    fun adjustQuantity(product: Product, increase: Boolean) {
        val current = _cartItems.value.toMutableList()
        val index = current.indexOfFirst { it.product.id == product.id }
        if (index != -1) {
            val item = current[index]
            if (increase) {
                current[index] = item.copy(quantity = item.quantity + 1)
            } else {
                if (item.quantity > 1) {
                    current[index] = item.copy(quantity = item.quantity - 1)
                } else {
                    current.removeAt(index)
                }
            }
        }
        _cartItems.value = current
    }

    fun setNotes(product: Product, notes: String) {
        val current = _cartItems.value.toMutableList()
        val index = current.indexOfFirst { it.product.id == product.id }
        if (index != -1) {
            current[index] = current[index].copy(notes = notes)
        }
        _cartItems.value = current
    }

    fun setDineIn(dineIn: Boolean) {
        _isDineIn.value = dineIn
        _currentTable.value = if (dineIn) "12" else "Takeaway"
    }

    fun setTableNo(tableNo: String) {
        _currentTable.value = tableNo
    }

    fun applyPromo(code: String): Boolean {
        return if (code.trim().uppercase() == "PROMOYON") {
            _appliedPromoCode.value = "PROMOYON"
            _promoDiscountRate.value = 0.10 // 10%
            true
        } else {
            _appliedPromoCode.value = null
            _promoDiscountRate.value = 0.0
            false
        }
    }

    // Checkout: Places items in cart as a live tracked order
    fun checkout(): Order? {
        val currentCart = _cartItems.value
        if (currentCart.isEmpty()) return null

        val subtotal = currentCart.sumOf { it.product.price * it.quantity }
        val tax = subtotal * 0.10
        val service = subtotal * 0.05
        val discount = subtotal * _promoDiscountRate.value
        val total = subtotal + tax + service - discount

        val orderNum = (100 + (Math.random() * 900).toInt()).toString()
        val orderNo = "#ORD-$orderNum"
        val timeString = SimpleDateFormat("HH:mm", Locale.getDefault()).format(Date())

        val newOrder = Order(
            id = "ord_" + System.currentTimeMillis(),
            orderNo = orderNo,
            tableNo = _currentTable.value,
            items = currentCart,
            state = OrderState.PENDING,
            isTakeaway = !_isDineIn.value,
            estimatedMinutes = 12,
            totalAmount = total,
            timestamp = timeString
        )

        // Prepend new order in kitchen logs
        val updatedOrders = _orders.value.toMutableList()
        updatedOrders.add(0, newOrder)
        _orders.value = updatedOrders

        // Clear cart
        _cartItems.value = emptyList()

        // Set as dynamic tracked checkout
        _trackedOrder.value = newOrder

        // Update sales counts
        _totalRevenue.value += total
        _totalOrdersCount.value += 1

        val newTx = Transaction(orderNo, if (newOrder.isTakeaway) "Takeaway" else "Table " + newOrder.tableNo, "Preparing", total, "Just now")
        _transactions.value = listOf(newTx) + _transactions.value

        return newOrder
    }

    // Staff POS checkout helper
    fun checkoutPos(tableNo: String, customCart: List<CartItem>, isTakeaway: Boolean, discountAmount: Double = 0.0): Order {
        val subtotal = customCart.sumOf { it.product.price * it.quantity }
        val tax = subtotal * 0.10
        val service = subtotal * 0.05
        val total = subtotal + tax + service - discountAmount

        val orderNum = (100 + (Math.random() * 900).toInt()).toString()
        val orderNo = "#ORD-$orderNum"
        val timeString = SimpleDateFormat("HH:mm", Locale.getDefault()).format(Date())

        val newOrder = Order(
            id = "ord_" + System.currentTimeMillis(),
            orderNo = orderNo,
            tableNo = tableNo,
            items = customCart,
            state = OrderState.PENDING,
            isTakeaway = isTakeaway,
            estimatedMinutes = 12,
            totalAmount = total,
            timestamp = timeString
        )

        val updatedOrders = _orders.value.toMutableList()
        updatedOrders.add(0, newOrder)
        _orders.value = updatedOrders

        _totalRevenue.value += total
        _totalOrdersCount.value += 1

        val newTx = Transaction(orderNo, if (isTakeaway) "Takeaway" else "Table $tableNo", "Preparing", total, "Just now")
        _transactions.value = listOf(newTx) + _transactions.value

        return newOrder
    }

    // Advance orders in the kitchen list
    fun updateOrderState(orderId: String, nextState: OrderState) {
        // Update live in orders
        _orders.value = _orders.value.map { order ->
            if (order.id == orderId) {
                val updated = order.copy(state = nextState)
                // If this is currently tracked by customer, keep in sync
                if (_trackedOrder.value?.id == orderId) {
                    _trackedOrder.value = updated
                }
                updated
            } else {
                order
            }
        }

        // Keep dynamic transaction listings updated
        _orders.value.find { it.id == orderId }?.let { order ->
            if (nextState == OrderState.COMPLETED) {
                _transactions.value = _transactions.value.map { tx ->
                    if (tx.orderNo == order.orderNo) tx.copy(status = "Completed") else tx
                }
            }
        }
    }

    // Simulates calling waiter / caterer services
    fun callWaiter() {
        _isCallWaiterActive.value = true
    }

    fun dismissCallWaiter() {
        _isCallWaiterActive.value = false
    }

    // Replenishment trigger
    fun restockItem(itemId: String) {
        _restockItems.value = _restockItems.value.map { item ->
            if (item.id == itemId) {
                // Instantly restocks to target level
                item.copy(currentAmount = item.goalAmount)
            } else {
                item
            }
        }
    }
}
