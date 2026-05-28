package com.example.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.*
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.grid.GridCells
import androidx.compose.foundation.lazy.grid.LazyVerticalGrid
import androidx.compose.foundation.lazy.grid.items
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.draw.drawBehind
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import coil.compose.AsyncImage
import com.example.model.CartItem
import com.example.model.Product
import com.example.viewmodel.RestoViewModel

@OptIn(ExperimentalLayoutApi::class)
@Composable
fun PosScreen(
    viewModel: RestoViewModel,
    modifier: Modifier = Modifier
) {
    // POS has its own temporary in-memory billing cart
    val products = viewModel.products
    var posCart by remember { mutableStateOf(listOf<CartItem>()) }
    var posTableNo by remember { mutableStateOf("08") }
    var posIsTakeaway by remember { mutableStateOf(false) }
    var discountInput by remember { mutableStateOf(15000.0) } // Mock template discount has Rp 15,000

    var selectedCategory by remember { mutableStateOf("Makanan") }
    val categories = listOf("Makanan", "Minuman")

    val filteredProducts = products.filter { it.category == selectedCategory }

    val subtotal = posCart.sumOf { it.product.price * it.quantity }
    val tax = subtotal * 0.10
    val service = subtotal * 0.05
    val total = (subtotal + tax + service - discountInput).coerceAtLeast(0.0)

    var showPaymentSuccess by remember { mutableStateOf(false) }

    Box(
        modifier = modifier
            .fillMaxSize()
            .background(MaterialTheme.colorScheme.background)
            .drawBehind {
                val dotSpacing = 24.dp.toPx()
                val dotRadius = 1.dp.toPx()
                val paintColor = Color(0xFFD7C3AE).copy(alpha = 0.2f)
                var x = 0f
                while (x < size.width) {
                    var y = 0f
                    while (y < size.height) {
                        drawCircle(color = paintColor, radius = dotRadius, center = Offset(x, y))
                        y += dotSpacing
                    }
                    x += dotSpacing
                }
            }
    ) {
        Column(modifier = Modifier.fillMaxSize()) {
            // Header Bar
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .background(Color.White)
                    .border(BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.3f)))
                    .padding(horizontal = 24.dp, vertical = 16.dp),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Row(
                    verticalAlignment = Alignment.CenterVertically,
                    horizontalArrangement = Arrangement.spacedBy(8.dp)
                ) {
                    Icon(
                        imageVector = Icons.Default.PointOfSale,
                        contentDescription = "POS Icon",
                        tint = MaterialTheme.colorScheme.primary,
                        modifier = Modifier.size(26.dp)
                    )
                    Column {
                        Text(
                            text = "Staff POS Terminal",
                            style = MaterialTheme.typography.displayMedium.copy(
                                fontSize = 18.sp,
                                color = MaterialTheme.colorScheme.primary,
                                fontWeight = FontWeight.Bold
                            )
                        )
                        Text(text = "Quick order entry for servers & cashiers.", fontSize = 11.sp, color = Color.Gray)
                    }
                }

                Box(
                    modifier = Modifier
                        .clip(RoundedCornerShape(8.dp))
                        .background(MaterialTheme.colorScheme.primaryContainer.copy(alpha = 0.2f))
                        .padding(horizontal = 12.dp, vertical = 4.dp)
                ) {
                    Text(
                        text = "POS-01",
                        fontWeight = FontWeight.Bold,
                        color = MaterialTheme.colorScheme.primary,
                        fontSize = 11.sp
                    )
                }
            }

            // Dual columns structure: Left column is item grid, Right is active receipt
            Row(
                modifier = Modifier
                    .fillMaxSize()
                    .weight(1f)
                    .padding(16.dp),
                horizontalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                // LEFT SIDE: SELECTION GRID
                Column(
                    modifier = Modifier
                        .weight(1.3f)
                        .fillMaxHeight(),
                    verticalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    // Category selector
                    Row(
                        horizontalArrangement = Arrangement.spacedBy(8.dp),
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        categories.forEach { cat ->
                            val isSelected = selectedCategory == cat
                            FilterChip(
                                selected = isSelected,
                                onClick = { selectedCategory = cat },
                                label = { Text(cat, fontWeight = FontWeight.Bold) },
                                shape = RoundedCornerShape(9999.dp),
                                colors = FilterChipDefaults.filterChipColors(
                                    selectedContainerColor = MaterialTheme.colorScheme.primary,
                                    selectedLabelColor = Color.White
                                )
                            )
                        }
                    }

                    // Grid layout lists
                    LazyVerticalGrid(
                        columns = GridCells.Adaptive(minSize = 150.dp),
                        modifier = Modifier.fillMaxSize(),
                        horizontalArrangement = Arrangement.spacedBy(12.dp),
                        verticalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        items(filteredProducts) { item ->
                            Card(
                                colors = CardDefaults.cardColors(containerColor = Color.White),
                                border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.3f)),
                                shape = RoundedCornerShape(20.dp),
                                onClick = {
                                    val current = posCart.toMutableList()
                                    val index = current.indexOfFirst { it.product.id == item.id }
                                    if (index != -1) {
                                        current[index] = current[index].copy(quantity = current[index].quantity + 1)
                                    } else {
                                        current.add(CartItem(item, 1))
                                    }
                                    posCart = current
                                }
                            ) {
                                Column {
                                    AsyncImage(
                                        model = item.imageUrl,
                                        contentDescription = item.name,
                                        contentScale = ContentScale.Crop,
                                        modifier = Modifier
                                            .fillMaxWidth()
                                            .height(100.dp)
                                    )
                                    Column(modifier = Modifier.padding(12.dp)) {
                                        Text(
                                            text = item.name,
                                            fontWeight = FontWeight.Bold,
                                            fontSize = 13.sp,
                                            maxLines = 1
                                        )
                                        Spacer(modifier = Modifier.height(2.dp))
                                        Text(
                                            text = "Rp %,.0f".format(item.price).replace(',', '.'),
                                            color = MaterialTheme.colorScheme.primary,
                                            fontSize = 12.sp,
                                            fontWeight = FontWeight.Bold
                                        )
                                    }
                                }
                            }
                        }
                    }
                }

                // RIGHT SIDE: ACTIVE BILL RECEIPT
                Card(
                    modifier = Modifier
                        .weight(1f)
                        .fillMaxHeight(),
                    colors = CardDefaults.cardColors(containerColor = Color.White),
                    shape = RoundedCornerShape(24.dp),
                    border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.3f))
                ) {
                    Column(modifier = Modifier.padding(16.dp)) {
                        Text(
                            text = "Active Bill",
                            fontWeight = FontWeight.Black,
                            fontSize = 15.sp,
                            color = MaterialTheme.colorScheme.onBackground
                        )

                        Spacer(modifier = Modifier.height(12.dp))

                        // Controls input for table & service
                        Row(
                            horizontalArrangement = Arrangement.spacedBy(8.dp),
                            modifier = Modifier.fillMaxWidth()
                        ) {
                            OutlinedTextField(
                                value = posTableNo,
                                onValueChange = { posTableNo = it },
                                label = { Text("Table", fontSize = 10.sp) },
                                modifier = Modifier.weight(1f),
                                singleLine = true,
                                shape = RoundedCornerShape(12.dp),
                                textStyle = TextStyle(fontSize = 13.sp)
                            )

                            // Dine / takeaway buttons
                            Box(
                                modifier = Modifier
                                    .weight(1.5f)
                                    .align(Alignment.CenterVertically)
                                    .height(48.dp)
                                    .clip(RoundedCornerShape(12.dp))
                                    .background(MaterialTheme.colorScheme.background)
                                    .clickable { posIsTakeaway = !posIsTakeaway },
                                contentAlignment = Alignment.Center
                            ) {
                                Text(
                                    text = if (posIsTakeaway) "TAKEAWAY" else "DINE-IN",
                                    fontWeight = FontWeight.Bold,
                                    color = MaterialTheme.colorScheme.primary,
                                    fontSize = 11.sp
                                )
                            }
                        }

                        HorizontalDivider(color = Color.LightGray.copy(alpha = 0.3f), modifier = Modifier.padding(vertical = 12.dp))

                        // Selected items list
                        LazyColumn(
                            modifier = Modifier
                                .weight(1f)
                                .fillMaxWidth()
                        ) {
                            items(posCart) { item ->
                                Row(
                                    modifier = Modifier
                                        .fillMaxWidth()
                                        .padding(vertical = 8.dp),
                                    verticalAlignment = Alignment.CenterVertically,
                                    horizontalArrangement = Arrangement.SpaceBetween
                                ) {
                                    Column(modifier = Modifier.weight(1f)) {
                                        Text(
                                            text = item.product.name,
                                            fontWeight = FontWeight.Bold,
                                            fontSize = 13.sp
                                        )
                                        Text(
                                            text = "${item.quantity}x @ Rp %,.0f".format(item.product.price).replace(',', '.'),
                                            fontSize = 11.sp,
                                            color = Color.Gray
                                        )
                                    }

                                    // +/- selectors for cashier adjust
                                    Row(
                                        verticalAlignment = Alignment.CenterVertically,
                                        horizontalArrangement = Arrangement.spacedBy(8.dp)
                                    ) {
                                        IconButton(
                                            onClick = {
                                                val current = posCart.toMutableList()
                                                val index = current.indexOfFirst { it.product.id == item.product.id }
                                                if (index != -1) {
                                                    val itm = current[index]
                                                    if (itm.quantity > 1) {
                                                        current[index] = itm.copy(quantity = itm.quantity - 1)
                                                    } else {
                                                        current.removeAt(index)
                                                    }
                                                }
                                                posCart = current
                                            },
                                            modifier = Modifier.size(24.dp)
                                        ) {
                                            Icon(Icons.Default.Remove, contentDescription = "Sub", modifier = Modifier.size(14.dp))
                                        }

                                        Text(
                                            text = item.quantity.toString(),
                                            fontWeight = FontWeight.Bold,
                                            fontSize = 13.sp
                                        )

                                        IconButton(
                                            onClick = {
                                                val current = posCart.toMutableList()
                                                val index = current.indexOfFirst { it.product.id == item.product.id }
                                                if (index != -1) {
                                                    current[index] = current[index].copy(quantity = current[index].quantity + 1)
                                                }
                                                posCart = current
                                            },
                                            modifier = Modifier.size(24.dp)
                                        ) {
                                            Icon(Icons.Default.Add, contentDescription = "Add", modifier = Modifier.size(14.dp))
                                        }
                                    }
                                }
                            }
                            if (posCart.isEmpty()) {
                                item {
                                    Column(
                                        modifier = Modifier
                                            .fillMaxWidth()
                                            .padding(24.dp),
                                        horizontalAlignment = Alignment.CenterHorizontally
                                    ) {
                                        Icon(Icons.Default.Inbox, contentDescription = "Empty", tint = Color.LightGray)
                                        Spacer(modifier = Modifier.height(8.dp))
                                        Text("Bill is empty", fontSize = 12.sp, color = Color.Gray)
                                    }
                                }
                            }
                        }

                        // Pricing summaries
                        Spacer(modifier = Modifier.height(8.dp))
                        Row(
                            horizontalArrangement = Arrangement.SpaceBetween,
                            modifier = Modifier.fillMaxWidth()
                        ) {
                            Text("Subtotal", fontSize = 11.sp, color = Color.Gray)
                            Text("Rp %,.0f".format(subtotal).replace(',', '.'), fontSize = 11.sp, fontWeight = FontWeight.Bold)
                        }
                        Spacer(modifier = Modifier.height(4.dp))
                        Row(
                            horizontalArrangement = Arrangement.SpaceBetween,
                            modifier = Modifier.fillMaxWidth()
                        ) {
                            Text("Discount Manual", fontSize = 11.sp, color = Color(0xFFEF4444))
                            Text("- Rp %,.0f".format(discountInput).replace(',', '.'), fontSize = 11.sp, color = Color(0xFFEF4444), fontWeight = FontWeight.Bold)
                        }
                        Spacer(modifier = Modifier.height(4.dp))
                        Row(
                            horizontalArrangement = Arrangement.SpaceBetween,
                            modifier = Modifier.fillMaxWidth()
                        ) {
                            Text("Tax & Svc (15%)", fontSize = 11.sp, color = Color.Gray)
                            Text("Rp %,.0f".format(tax + service).replace(',', '.'), fontSize = 11.sp, fontWeight = FontWeight.Bold)
                        }

                        HorizontalDivider(color = Color.LightGray.copy(alpha = 0.3f), modifier = Modifier.padding(vertical = 12.dp))

                        Row(
                            horizontalArrangement = Arrangement.SpaceBetween,
                            verticalAlignment = Alignment.CenterVertically,
                            modifier = Modifier.fillMaxWidth()
                        ) {
                            Text("Total", fontWeight = FontWeight.Black, fontSize = 15.sp)
                            Text(
                                "Rp %,.0f".format(total).replace(',', '.'),
                                fontWeight = FontWeight.Black,
                                fontSize = 16.sp,
                                color = MaterialTheme.colorScheme.primary
                            )
                        }

                        Spacer(modifier = Modifier.height(16.dp))

                        // Charge bill button
                        Button(
                            onClick = {
                                if (posCart.isNotEmpty()) {
                                    viewModel.checkoutPos(posTableNo, posCart, posIsTakeaway, discountInput)
                                    posCart = emptyList()
                                    showPaymentSuccess = true
                                }
                            },
                            colors = ButtonDefaults.buttonColors(containerColor = Color(0xFF10B981)),
                            shape = RoundedCornerShape(12.dp),
                            modifier = Modifier
                                .fillMaxWidth()
                                .height(48.dp),
                            enabled = posCart.isNotEmpty()
                        ) {
                            Row(
                                verticalAlignment = Alignment.CenterVertically,
                                horizontalArrangement = Arrangement.spacedBy(8.dp)
                            ) {
                                Icon(Icons.Default.Payment, contentDescription = "Payment", tint = Color.White)
                                Text("CHARGE BILL", fontWeight = FontWeight.Bold, fontSize = 13.sp, color = Color.White)
                            }
                        }
                    }
                }
            }
        }

        // Notification overlay for payment charge confirmation
        if (showPaymentSuccess) {
            AlertDialog(
                onDismissRequest = { showPaymentSuccess = false },
                confirmButton = {
                    Button(
                        onClick = { showPaymentSuccess = false },
                        colors = ButtonDefaults.buttonColors(containerColor = MaterialTheme.colorScheme.primary)
                    ) {
                        Text("Selesai")
                    }
                },
                title = { Text("Payment Successful!", fontWeight = FontWeight.Black) },
                icon = { Icon(Icons.Default.CheckCircle, contentDescription = "Success", tint = Color(0xFF10B981), modifier = Modifier.size(48.dp)) },
                text = {
                    Text(
                        "Transaksi POS berhasil dicatat. Pesanan telah didorong secara langsung ke Kitchen Display KDS.",
                        textAlign = androidx.compose.ui.text.style.TextAlign.Center
                    )
                }
            )
        }
    }
}
