package com.example.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.*
import androidx.compose.foundation.layout.*
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
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.model.Order
import com.example.model.OrderState
import com.example.viewmodel.RestoViewModel

@Composable
fun KdsScreen(
    viewModel: RestoViewModel,
    modifier: Modifier = Modifier
) {
    val orders by viewModel.orders.collectAsState()
    val isCallWaiterActive by viewModel.isCallWaiterActive.collectAsState()

    // Filter different queue listings
    val activeTickets = orders.filter { it.state != OrderState.COMPLETED }
    val preparingOrders = orders.filter { it.state == OrderState.COOKING }
    val readyOrders = orders.filter { it.state == OrderState.READY }

    Box(
        modifier = modifier
            .fillMaxSize()
            .background(Color(0xFF0B0F19)) // Beautiful cosmic/dark theme for kitchen screens
            .drawBehind {
                val dotSpacing = 24.dp.toPx()
                val dotRadius = 1.dp.toPx()
                val paintColor = Color(0xFF1E293B)
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
                    .background(Color(0xFF0F172A))
                    .padding(horizontal = 24.dp, vertical = 20.dp),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Row(
                    verticalAlignment = Alignment.CenterVertically,
                    horizontalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    Icon(
                        imageVector = Icons.Default.Computer,
                        contentDescription = "KDS Icon",
                        tint = Color(0xFFFEC73F),
                        modifier = Modifier.size(28.dp)
                    )
                    Column {
                        Text(
                            text = "KITCHEN DISPLAY SYSTEM (KDS)",
                            fontWeight = FontWeight.Black,
                            fontSize = 18.sp,
                            color = Color.White
                        )
                        Text(
                            text = "Live cooking logs and table service channels.",
                            fontSize = 11.sp,
                            color = Color.Gray
                        )
                    }
                }

                // Call waiter alert showing live on KDS
                AnimatedVisibility(
                    visible = isCallWaiterActive,
                    enter = fadeIn() + scaleIn(),
                    exit = fadeOut() + scaleOut()
                ) {
                    Button(
                        onClick = { viewModel.dismissCallWaiter() },
                        colors = ButtonDefaults.buttonColors(containerColor = Color(0xFFEF4444)),
                        shape = RoundedCornerShape(12.dp)
                    ) {
                        Row(
                            verticalAlignment = Alignment.CenterVertically,
                            horizontalArrangement = Arrangement.spacedBy(6.dp)
                        ) {
                            Icon(Icons.Default.NotificationsActive, contentDescription = "Active Alert", tint = Color.White)
                            Text("CALL WAITER: TABLE 12", color = Color.White, fontWeight = FontWeight.Bold, fontSize = 11.sp)
                        }
                    }
                }
            }

            // Two-column layout: Left column = Active cooking ticket posts, Right column = Live pickup status columns
            Row(
                modifier = Modifier
                    .fillMaxSize()
                    .weight(1f)
                    .padding(16.dp),
                horizontalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                // LEFT SIDE: KITCHEN TICKETS BOARD
                Column(
                    modifier = Modifier
                        .weight(1.3f)
                        .fillMaxHeight(),
                    verticalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.SpaceBetween,
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Text(
                            text = "Active Cooking Tickets",
                            fontWeight = FontWeight.Bold,
                            fontSize = 16.sp,
                            color = Color.White
                        )
                        Box(
                            modifier = Modifier
                                .clip(RoundedCornerShape(8.dp))
                                .background(Color(0xFF1E293B))
                                .padding(horizontal = 8.dp, vertical = 4.dp)
                        ) {
                            Text(
                                text = "${activeTickets.size} Tickets",
                                fontSize = 11.sp,
                                color = Color(0xFFFEC73F),
                                fontWeight = FontWeight.Bold
                            )
                        }
                    }

                    if (activeTickets.isEmpty()) {
                        Box(
                            modifier = Modifier
                                .fillMaxSize()
                                .clip(RoundedCornerShape(24.dp))
                                .background(Color(0xFF0F172A))
                                .padding(24.dp),
                            contentAlignment = Alignment.Center
                        ) {
                            Column(horizontalAlignment = Alignment.CenterHorizontally) {
                                Icon(Icons.Default.DoneAll, contentDescription = "Done", tint = Color.DarkGray, modifier = Modifier.size(48.dp))
                                Spacer(modifier = Modifier.height(12.dp))
                                Text("No Pending Orders", fontWeight = FontWeight.Bold, color = Color.LightGray)
                                Text("Waiting for checkouts from customer app.", fontSize = 12.sp, color = Color.Gray)
                            }
                        }
                    } else {
                        Column(
                            modifier = Modifier
                                .fillMaxSize()
                                .verticalScroll(rememberScrollState()),
                            verticalArrangement = Arrangement.spacedBy(12.dp)
                        ) {
                            activeTickets.forEach { order ->
                                Card(
                                    colors = CardDefaults.cardColors(containerColor = Color(0xFF0F172A)),
                                    shape = RoundedCornerShape(24.dp),
                                    border = BorderStroke(
                                        width = 1.dp,
                                        color = when (order.state) {
                                            OrderState.PENDING -> Color(0xFFF5A623).copy(alpha = 0.5f)
                                            OrderState.COOKING -> Color(0xFF3B82F6).copy(alpha = 0.5f)
                                            else -> Color.Green.copy(alpha = 0.5f)
                                        }
                                    )
                                ) {
                                    Column(modifier = Modifier.padding(16.dp)) {
                                        // Card Header
                                        Row(
                                            modifier = Modifier.fillMaxWidth(),
                                            horizontalArrangement = Arrangement.SpaceBetween,
                                            verticalAlignment = Alignment.CenterVertically
                                        ) {
                                            Row(
                                                verticalAlignment = Alignment.CenterVertically,
                                                horizontalArrangement = Arrangement.spacedBy(8.dp)
                                            ) {
                                                Text(
                                                    text = order.orderNo,
                                                    fontWeight = FontWeight.Black,
                                                    color = Color.White,
                                                    fontSize = 15.sp
                                                )
                                                Box(
                                                    modifier = Modifier
                                                        .clip(RoundedCornerShape(6.dp))
                                                        .background(
                                                            if (order.isTakeaway) Color(0xFFEF4444).copy(alpha = 0.2f)
                                                            else Color(0xFF10B981).copy(alpha = 0.2f)
                                                        )
                                                        .padding(horizontal = 6.dp, vertical = 2.dp)
                                                ) {
                                                    Text(
                                                        text = if (order.isTakeaway) "TAKEAWAY" else "TABLE ${order.tableNo}",
                                                        fontSize = 9.sp,
                                                        fontWeight = FontWeight.Bold,
                                                        color = if (order.isTakeaway) Color(0xFFEF4444) else Color(0xFF10B981)
                                                    )
                                                }
                                            }

                                            Text(
                                                text = "${order.estimatedMinutes}m est",
                                                color = Color(0xFFFEC73F),
                                                fontSize = 12.sp,
                                                fontWeight = FontWeight.Bold
                                            )
                                        }

                                        HorizontalDivider(color = Color.White.copy(alpha = 0.1f), modifier = Modifier.padding(vertical = 12.dp))

                                        // Item descriptions
                                        order.items.forEach { item ->
                                            Row(
                                                modifier = Modifier
                                                    .fillMaxWidth()
                                                    .padding(vertical = 4.dp),
                                                horizontalArrangement = Arrangement.SpaceBetween
                                            ) {
                                                Text(
                                                    text = "${item.quantity}x  ${item.product.name}",
                                                    fontWeight = FontWeight.Bold,
                                                    color = Color.White,
                                                    fontSize = 13.sp
                                                )
                                                if (item.notes.isNotEmpty()) {
                                                    Text(
                                                        text = "(${item.notes})",
                                                        color = Color(0xFFFEC73F),
                                                        fontSize = 11.sp,
                                                        fontWeight = FontWeight.Medium
                                                    )
                                                }
                                            }
                                        }

                                        Spacer(modifier = Modifier.height(16.dp))

                                        // Actions line
                                        Row(
                                            modifier = Modifier.fillMaxWidth(),
                                            horizontalArrangement = Arrangement.spacedBy(8.dp)
                                        ) {
                                            if (order.state == OrderState.PENDING) {
                                                Button(
                                                    onClick = { viewModel.updateOrderState(order.id, OrderState.COOKING) },
                                                    colors = ButtonDefaults.buttonColors(containerColor = Color(0xFFF5A623)),
                                                    shape = RoundedCornerShape(12.dp),
                                                    modifier = Modifier.weight(1f)
                                                ) {
                                                    Text("START COOKING", fontWeight = FontWeight.Bold, fontSize = 11.sp, color = Color.White)
                                                }
                                            } else if (order.state == OrderState.COOKING) {
                                                Button(
                                                    onClick = { viewModel.updateOrderState(order.id, OrderState.READY) },
                                                    colors = ButtonDefaults.buttonColors(containerColor = Color(0xFF10B981)),
                                                    shape = RoundedCornerShape(12.dp),
                                                    modifier = Modifier.weight(1f)
                                                ) {
                                                    Text("MARK READY", fontWeight = FontWeight.Bold, fontSize = 11.sp, color = Color.White)
                                                }
                                            } else if (order.state == OrderState.READY) {
                                                Button(
                                                    onClick = { viewModel.updateOrderState(order.id, OrderState.COMPLETED) },
                                                    colors = ButtonDefaults.buttonColors(containerColor = Color(0xFF3B82F6)),
                                                    shape = RoundedCornerShape(12.dp),
                                                    modifier = Modifier.weight(1f)
                                                ) {
                                                    Text("COMPLETE & SHIP", fontWeight = FontWeight.Bold, fontSize = 11.sp, color = Color.White)
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // RIGHT SIDE: QUEUE STATUS BOARD
                Column(
                    modifier = Modifier
                        .weight(1f)
                        .fillMaxHeight(),
                    verticalArrangement = Arrangement.spacedBy(12.dp)
                ) {
                    Text(
                        text = "Live Queue Status Board",
                        style = MaterialTheme.typography.displayMedium,
                        fontSize = 16.sp,
                        fontWeight = FontWeight.Bold,
                        color = Color.White
                    )

                    Row(
                        modifier = Modifier
                            .fillMaxSize()
                            .weight(1f),
                        horizontalArrangement = Arrangement.spacedBy(12.dp)
                    ) {
                        // Preparing queue column card
                        Card(
                            colors = CardDefaults.cardColors(containerColor = Color(0xFF0F172A)),
                            shape = RoundedCornerShape(24.dp),
                            modifier = Modifier
                                .weight(1f)
                                .fillMaxHeight()
                        ) {
                            Column(modifier = Modifier.padding(16.dp)) {
                                Text(
                                    text = "PREPARING",
                                    color = Color(0xFFF5A623),
                                    fontWeight = FontWeight.Black,
                                    fontSize = 11.sp,
                                    letterSpacing = 1.sp
                                )
                                Spacer(modifier = Modifier.height(12.dp))

                                Column(
                                    modifier = Modifier.fillMaxSize(),
                                    verticalArrangement = Arrangement.spacedBy(8.dp)
                                ) {
                                    preparingOrders.forEach { preparing ->
                                        Row(
                                            modifier = Modifier
                                                .fillMaxWidth()
                                                .clip(RoundedCornerShape(8.dp))
                                                .background(Color.White.copy(alpha = 0.05f))
                                                .padding(8.dp),
                                            horizontalArrangement = Arrangement.SpaceBetween,
                                            verticalAlignment = Alignment.CenterVertically
                                        ) {
                                            Text(
                                                text = preparing.orderNo,
                                                color = Color.White,
                                                fontWeight = FontWeight.Bold,
                                                fontSize = 12.sp
                                            )
                                            Box(
                                                modifier = Modifier
                                                    .size(10.dp)
                                                    .clip(CircleShape)
                                                    .background(Color(0xFFF5A623))
                                            )
                                        }
                                    }
                                    if (preparingOrders.isEmpty()) {
                                        Text(
                                            text = "Empty",
                                            fontSize = 12.sp,
                                            color = Color.DarkGray,
                                            modifier = Modifier.align(Alignment.CenterHorizontally)
                                        )
                                    }
                                }
                            }
                        }

                        // Ready queue column card
                        Card(
                            colors = CardDefaults.cardColors(containerColor = Color(0xFF0F172A)),
                            shape = RoundedCornerShape(24.dp),
                            modifier = Modifier
                                .weight(1f)
                                .fillMaxHeight()
                        ) {
                            Column(modifier = Modifier.padding(16.dp)) {
                                Text(
                                    text = "READY",
                                    color = Color(0xFF10B981),
                                    fontWeight = FontWeight.Black,
                                    fontSize = 11.sp,
                                    letterSpacing = 1.sp
                                )
                                Spacer(modifier = Modifier.height(12.dp))

                                Column(
                                    modifier = Modifier.fillMaxSize(),
                                    verticalArrangement = Arrangement.spacedBy(8.dp)
                                ) {
                                    readyOrders.forEach { ready ->
                                        Row(
                                            modifier = Modifier
                                                .fillMaxWidth()
                                                .clip(RoundedCornerShape(8.dp))
                                                .background(Color.White.copy(alpha = 0.05f))
                                                .padding(8.dp),
                                            horizontalArrangement = Arrangement.SpaceBetween,
                                            verticalAlignment = Alignment.CenterVertically
                                        ) {
                                            Text(
                                                text = ready.orderNo,
                                                color = Color.White,
                                                fontWeight = FontWeight.Bold,
                                                fontSize = 12.sp
                                            )
                                            IconButton(
                                                onClick = { viewModel.updateOrderState(ready.id, OrderState.COMPLETED) },
                                                modifier = Modifier.size(18.dp)
                                            ) {
                                                Icon(
                                                    imageVector = Icons.Default.CheckCircle,
                                                    contentDescription = "Complete",
                                                    tint = Color(0xFF10B981),
                                                    modifier = Modifier.size(14.dp)
                                                )
                                            }
                                        }
                                    }
                                    if (readyOrders.isEmpty()) {
                                        Text(
                                            text = "Empty",
                                            fontSize = 12.sp,
                                            color = Color.DarkGray,
                                            modifier = Modifier.align(Alignment.CenterHorizontally)
                                        )
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
