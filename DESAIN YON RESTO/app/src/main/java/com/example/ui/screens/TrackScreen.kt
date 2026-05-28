package com.example.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.*
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.lazy.LazyColumn
import androidx.compose.foundation.lazy.items
import androidx.compose.foundation.shape.CircleShape
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material.icons.outlined.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.draw.drawBehind
import androidx.compose.ui.geometry.Offset
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.layout.ContentScale
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.text.style.TextAlign
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import coil.compose.AsyncImage
import com.example.model.CartItem
import com.example.model.Order
import com.example.model.OrderState
import com.example.viewmodel.RestoViewModel
import kotlinx.coroutines.delay
import kotlinx.coroutines.launch

@OptIn(ExperimentalLayoutApi::class)
@Composable
fun TrackScreen(
    viewModel: RestoViewModel,
    modifier: Modifier = Modifier
) {
    val liveTrackedOrder by viewModel.trackedOrder.collectAsState()
    val isCallWaiterActive by viewModel.isCallWaiterActive.collectAsState()
    val scope = rememberCoroutineScope()

    var showQrDialog by remember { mutableStateOf(false) }
    var waiterFeedbackText by remember { mutableStateOf<String?>(null) }

    // Seed default tracking order if no live checkout has happened
    val demoOrder = remember {
        Order(
            id = "demo_track",
            orderNo = "#ORD-20231027-001",
            tableNo = "12",
            items = listOf(
                CartItem(viewModel.products[4], 1, "Extra Spicy Sauce"), // Salmon Mentai (Salmon Poke Bowl mockup counterpart)
                CartItem(viewModel.products[5], 2, "Less Sugar")        // Lychee Iced Tea counterpart
            ),
            state = OrderState.COOKING,
            isTakeaway = false,
            estimatedMinutes = 12,
            totalAmount = 141900.0,
            timestamp = "13:45"
        )
    }

    val activeOrder = liveTrackedOrder ?: demoOrder

    Box(
        modifier = modifier
            .fillMaxSize()
            .background(MaterialTheme.colorScheme.background)
            .drawBehind {
                val dotSpacing = 20.dp.toPx()
                val dotRadius = 1.dp.toPx()
                val paintColor = Color(0xFF835500).copy(alpha = 0.06f)
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
            // App Bar
            Row(
                modifier = Modifier
                    .fillMaxWidth()
                    .padding(horizontal = 24.dp, vertical = 16.dp),
                horizontalArrangement = Arrangement.SpaceBetween,
                verticalAlignment = Alignment.CenterVertically
            ) {
                Row(
                    verticalAlignment = Alignment.CenterVertically,
                    horizontalArrangement = Arrangement.spacedBy(8.dp)
                ) {
                    Icon(
                        imageVector = Icons.Default.Restaurant,
                        contentDescription = "Restaurant Icon",
                        tint = MaterialTheme.colorScheme.primary,
                        modifier = Modifier.size(24.dp)
                    )
                    Text(
                        text = "Lacak Pesanan ${activeOrder.orderNo}",
                        style = MaterialTheme.typography.displayMedium.copy(
                            fontSize = 18.sp,
                            color = MaterialTheme.colorScheme.primary,
                            fontWeight = FontWeight.ExtraBold
                        )
                    )
                }

                Box(
                    modifier = Modifier
                        .clip(RoundedCornerShape(9999.dp))
                        .background(MaterialTheme.colorScheme.primaryContainer)
                        .padding(horizontal = 14.dp, vertical = 6.dp)
                ) {
                    Text(
                        text = "Table ${activeOrder.tableNo}",
                        fontWeight = FontWeight.Bold,
                        color = MaterialTheme.colorScheme.onPrimaryContainer,
                        style = MaterialTheme.typography.bodyMedium,
                        fontSize = 12.sp
                    )
                }
            }

            LazyColumn(
                modifier = Modifier
                    .fillMaxSize()
                    .weight(1f),
                contentPadding = PaddingValues(horizontal = 24.dp, vertical = 8.dp),
                verticalArrangement = Arrangement.spacedBy(16.dp)
            ) {
                // Time Estimate Widget
                item {
                    Card(
                        colors = CardDefaults.cardColors(containerColor = Color.White),
                        shape = RoundedCornerShape(28.dp),
                        border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.2f)),
                        elevation = CardDefaults.cardElevation(defaultElevation = 4.dp),
                        modifier = Modifier.fillMaxWidth()
                    ) {
                        Column(
                            modifier = Modifier
                                .fillMaxWidth()
                                .padding(24.dp),
                            horizontalAlignment = Alignment.CenterHorizontally,
                            verticalArrangement = Arrangement.Center
                        ) {
                            Text(
                                text = "ESTIMASI PESANAN TIBA",
                                style = MaterialTheme.typography.labelLarge,
                                color = Color.Gray,
                                fontWeight = FontWeight.Black,
                                letterSpacing = 1.sp
                            )
                            Spacer(modifier = Modifier.height(8.dp))
                            val minutesText = when (activeOrder.state) {
                                OrderState.PENDING -> "~15 Menit"
                                OrderState.COOKING -> "~12 Menit"
                                OrderState.READY -> "Pesanan Siap!"
                                OrderState.COMPLETED -> "Diterima!"
                            }
                            Text(
                                text = minutesText,
                                color = MaterialTheme.colorScheme.primary,
                                style = MaterialTheme.typography.displayLarge,
                                fontSize = 32.sp,
                                fontWeight = FontWeight.Black
                            )
                            Spacer(modifier = Modifier.height(4.dp))
                            Row(
                                verticalAlignment = Alignment.CenterVertically,
                                horizontalArrangement = Arrangement.spacedBy(4.dp)
                            ) {
                                Icon(
                                    imageVector = Icons.Default.Event,
                                    contentDescription = "Clock",
                                    tint = Color.Gray,
                                    modifier = Modifier.size(16.dp)
                                )
                                Text(
                                    text = "Pukul ${activeOrder.timestamp} WIB",
                                    color = Color.Gray,
                                    fontSize = 13.sp
                                )
                            }
                        }
                    }
                }

                // Progress tracker stepper widget
                item {
                    Card(
                        colors = CardDefaults.cardColors(containerColor = Color.White.copy(alpha = 0.95f)),
                        shape = RoundedCornerShape(28.dp),
                        border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.2f)),
                        elevation = CardDefaults.cardElevation(defaultElevation = 2.dp),
                        modifier = Modifier.fillMaxWidth()
                    ) {
                        Column(modifier = Modifier.padding(20.dp)) {
                            // Steps layout row
                            Row(
                                modifier = Modifier
                                    .fillMaxWidth()
                                    .padding(vertical = 8.dp),
                                horizontalArrangement = Arrangement.SpaceBetween,
                                verticalAlignment = Alignment.CenterVertically
                            ) {
                                // Dynamic steps rendering
                                TrackStep(
                                    stepName = "Pending",
                                    isActive = activeOrder.state.ordinal >= OrderState.PENDING.ordinal,
                                    isDone = activeOrder.state.ordinal > OrderState.PENDING.ordinal,
                                    icon = Icons.Default.Check
                                )

                                TrackStep(
                                    stepName = "Cooking",
                                    isActive = activeOrder.state.ordinal >= OrderState.COOKING.ordinal,
                                    isDone = activeOrder.state.ordinal > OrderState.COOKING.ordinal,
                                    icon = Icons.Default.Restaurant
                                )

                                TrackStep(
                                    stepName = "Ready",
                                    isActive = activeOrder.state.ordinal >= OrderState.READY.ordinal,
                                    isDone = activeOrder.state.ordinal > OrderState.READY.ordinal,
                                    icon = Icons.Default.DinnerDining
                                )

                                TrackStep(
                                    stepName = "Completed",
                                    isActive = activeOrder.state.ordinal >= OrderState.COMPLETED.ordinal,
                                    isDone = activeOrder.state.ordinal > OrderState.COMPLETED.ordinal,
                                    icon = Icons.Default.CheckCircle
                                )
                            }

                            Spacer(modifier = Modifier.height(16.dp))

                            // Box message
                            val alertMessage = when (activeOrder.state) {
                                OrderState.PENDING -> "Pesanan Anda berhasil dikirim ke dapur. Menunggu persetujuan koki."
                                OrderState.COOKING -> "Chef sedang menyiapkan menu pesanan Anda dengan bahan segar terbaik."
                                OrderState.READY -> "Pesanan Anda sudah SIAP! Silakan ambil atau panggil pelayan untuk mengantarkannya."
                                OrderState.COMPLETED -> "Pesanan Anda selesai! Selamat menikmati hidangan spesial dari YON RESTO."
                            }

                            Row(
                                modifier = Modifier
                                    .clip(RoundedCornerShape(12.dp))
                                    .background(MaterialTheme.colorScheme.primary.copy(alpha = 0.05f))
                                    .border(BorderStroke(1.dp, MaterialTheme.colorScheme.primaryContainer), RoundedCornerShape(12.dp))
                                    .padding(12.dp),
                                verticalAlignment = Alignment.CenterVertically,
                                horizontalArrangement = Arrangement.spacedBy(8.dp)
                            ) {
                                Icon(
                                    imageVector = Icons.Default.Info,
                                    contentDescription = "Alert Info",
                                    tint = MaterialTheme.colorScheme.primaryContainer,
                                    modifier = Modifier.size(20.dp)
                                )
                                Text(
                                    text = alertMessage,
                                    fontSize = 12.sp,
                                    fontWeight = FontWeight.Medium,
                                    color = MaterialTheme.colorScheme.onBackground
                                )
                            }
                        }
                    }
                }

                // Rincian Pesanan
                item {
                    Card(
                        colors = CardDefaults.cardColors(containerColor = Color.White),
                        shape = RoundedCornerShape(28.dp),
                        border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.2f)),
                        modifier = Modifier.fillMaxWidth()
                    ) {
                        Column(modifier = Modifier.padding(24.dp)) {
                            Text(
                                text = "Rincian Pesanan",
                                fontWeight = FontWeight.Bold,
                                fontSize = 16.sp,
                                color = MaterialTheme.colorScheme.onBackground
                            )
                            Spacer(modifier = Modifier.height(16.dp))

                            activeOrder.items.forEach { item ->
                                Row(
                                    modifier = Modifier
                                        .fillMaxWidth()
                                        .padding(vertical = 8.dp),
                                    verticalAlignment = Alignment.CenterVertically
                                ) {
                                    AsyncImage(
                                        model = item.product.imageUrl,
                                        contentDescription = item.product.name,
                                        contentScale = ContentScale.Crop,
                                        modifier = Modifier
                                            .size(56.dp)
                                            .clip(RoundedCornerShape(12.dp))
                                    )

                                    Spacer(modifier = Modifier.width(16.dp))

                                    Column(modifier = Modifier.weight(1f)) {
                                        Text(
                                            text = item.product.name,
                                            fontWeight = FontWeight.Bold,
                                            fontSize = 14.sp
                                        )
                                        Text(
                                            text = "${item.quantity}x • ${item.notes.ifEmpty { "Pilihan Standar" }}",
                                            fontSize = 11.sp,
                                            color = Color.Gray
                                        )
                                    }

                                    Text(
                                        text = "Rp %,.0f".format(item.product.price * item.quantity).replace(',', '.'),
                                        fontWeight = FontWeight.Bold,
                                        color = MaterialTheme.colorScheme.primary,
                                        fontSize = 14.sp
                                    )
                                }
                                Spacer(modifier = Modifier.height(4.dp))
                            }

                            HorizontalDivider(modifier = Modifier.padding(vertical = 12.dp), color = Color.LightGray.copy(alpha = 0.3f))

                            val subtotal = activeOrder.totalAmount / 1.15 // quick approximate backwards math to align totals beautifully with mockup
                            val taxation = subtotal * 0.15

                            Row(
                                modifier = Modifier.fillMaxWidth(),
                                horizontalArrangement = Arrangement.SpaceBetween
                            ) {
                                Text(text = "Subtotal", fontSize = 12.sp, color = Color.Gray)
                                Text(text = "Rp %,.0f".format(subtotal).replace(',', '.'), fontSize = 12.sp)
                            }
                            Spacer(modifier = Modifier.height(6.dp))
                            Row(
                                modifier = Modifier.fillMaxWidth(),
                                horizontalArrangement = Arrangement.SpaceBetween
                            ) {
                                Text(text = "Tax & Service (15%)", fontSize = 12.sp, color = Color.Gray)
                                Text(text = "Rp %,.0f".format(taxation).replace(',', '.'), fontSize = 12.sp)
                            }
                            Spacer(modifier = Modifier.height(12.dp))
                            Row(
                                modifier = Modifier.fillMaxWidth(),
                                horizontalArrangement = Arrangement.SpaceBetween,
                                verticalAlignment = Alignment.CenterVertically
                            ) {
                                Text(text = "Total", fontWeight = FontWeight.Bold, fontSize = 16.sp)
                                Text(
                                    text = "Rp %,.0f".format(activeOrder.totalAmount).replace(',', '.'),
                                    fontWeight = FontWeight.Black,
                                    color = MaterialTheme.colorScheme.primary,
                                    fontSize = 18.sp
                                )
                            }
                        }
                    }
                }

                // Bottom Action buttons: QR STRUK and PANGGIL PELAYAN
                item {
                    Row(
                        modifier = Modifier
                            .fillMaxWidth()
                            .padding(bottom = 96.dp),
                        horizontalArrangement = Arrangement.spacedBy(16.dp)
                    ) {
                        // QR Code Card Button
                        Card(
                            colors = CardDefaults.cardColors(containerColor = Color.White),
                            border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.2f)),
                            shape = RoundedCornerShape(24.dp),
                            onClick = { showQrDialog = true },
                            modifier = Modifier
                                .weight(1f)
                                .height(120.dp)
                        ) {
                            Column(
                                modifier = Modifier.fillMaxSize(),
                                horizontalAlignment = Alignment.CenterHorizontally,
                                verticalArrangement = Arrangement.Center
                            ) {
                                Box(
                                    modifier = Modifier
                                        .size(48.dp)
                                        .clip(RoundedCornerShape(12.dp))
                                        .background(MaterialTheme.colorScheme.background),
                                    contentAlignment = Alignment.Center
                                ) {
                                    Icon(
                                        imageVector = Icons.Default.QrCode2,
                                        contentDescription = "QR Code",
                                        tint = MaterialTheme.colorScheme.primary,
                                        modifier = Modifier.size(28.dp)
                                    )
                                }
                                Spacer(modifier = Modifier.height(8.dp))
                                Text(
                                    text = "QR STRUK",
                                    style = MaterialTheme.typography.labelLarge,
                                    color = Color.Gray,
                                    fontSize = 11.sp,
                                    fontWeight = FontWeight.Bold
                                )
                            }
                        }

                        // Call Waiter Button Plate
                        Card(
                            colors = CardDefaults.cardColors(containerColor = MaterialTheme.colorScheme.primary),
                            shape = RoundedCornerShape(24.dp),
                            onClick = {
                                viewModel.callWaiter()
                                scope.launch {
                                    waiterFeedbackText = "Mohon Tunggu..."
                                    delay(2000)
                                    waiterFeedbackText = "Catering Dipanggil"
                                    delay(1500)
                                    waiterFeedbackText = null
                                }
                            },
                            modifier = Modifier
                                .weight(1f)
                                .height(120.dp)
                        ) {
                            Column(
                                modifier = Modifier.fillMaxSize(),
                                horizontalAlignment = Alignment.CenterHorizontally,
                                verticalArrangement = Arrangement.Center
                            ) {
                                Box(
                                    modifier = Modifier
                                        .size(48.dp)
                                        .clip(RoundedCornerShape(12.dp))
                                        .background(Color.White.copy(alpha = 0.2f)),
                                    contentAlignment = Alignment.Center
                                ) {
                                    Icon(
                                        imageVector = if (viewModel.isCallWaiterActive.value) Icons.Default.NotificationsActive else Icons.Default.Notifications,
                                        contentDescription = "Call waiter bell",
                                        tint = Color.White,
                                        modifier = Modifier.size(28.dp)
                                    )
                                }
                                Spacer(modifier = Modifier.height(8.dp))
                                Text(
                                    text = waiterFeedbackText ?: "PANGGIL PELAYAN",
                                    style = MaterialTheme.typography.labelLarge,
                                    color = Color.White,
                                    fontSize = 11.sp,
                                    fontWeight = FontWeight.Bold
                                )
                            }
                        }
                    }
                }
            }
        }

        // QR Code Dialog simulation
        if (showQrDialog) {
            AlertDialog(
                onDismissRequest = { showQrDialog = false },
                confirmButton = {
                    TextButton(onClick = { showQrDialog = false }) {
                        Text("Tutup", color = MaterialTheme.colorScheme.primary)
                    }
                },
                title = { Text("E-Struk / QR Struk Pembayaran", fontWeight = FontWeight.Bold) },
                text = {
                    Column(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalAlignment = Alignment.CenterHorizontally
                    ) {
                        Text(
                            text = "Tunjukkan QR ini ke kasir untuk proses pembayaran langsung via POS terminal.",
                            textAlign = TextAlign.Center,
                            fontSize = 13.sp,
                            color = Color.Gray
                        )
                        Spacer(modifier = Modifier.height(16.dp))
                        Icon(
                            imageVector = Icons.Default.QrCode2,
                            contentDescription = "Receipt QR",
                            tint = Color.Black,
                            modifier = Modifier.size(160.dp)
                        )
                        Spacer(modifier = Modifier.height(8.dp))
                        Text(
                            text = activeOrder.orderNo,
                            fontWeight = FontWeight.Bold,
                            color = MaterialTheme.colorScheme.primary
                        )
                    }
                }
            )
        }
    }
}

@Composable
fun TrackStep(
    stepName: String,
    isActive: Boolean,
    isDone: Boolean,
    icon: androidx.compose.ui.graphics.vector.ImageVector,
) {
    val stepColor = when {
        isDone -> Color(0xFF10B981) // Green success
        isActive -> Color(0xFFF5A623) // Orange / current
        else -> Color.LightGray.copy(alpha = 0.5f)
    }

    Column(
        horizontalAlignment = Alignment.CenterHorizontally,
        verticalArrangement = Arrangement.spacedBy(4.dp),
        modifier = Modifier.width(64.dp)
    ) {
        Box(
            modifier = Modifier
                .size(42.dp)
                .clip(CircleShape)
                .background(if (isActive) stepColor else Color.LightGray.copy(alpha = 0.2f))
                .border(2.dp, if (isActive) Color.Transparent else Color.LightGray.copy(alpha = 0.5f), CircleShape),
            contentAlignment = Alignment.Center
        ) {
            Icon(
                imageVector = if (isDone) Icons.Default.Check else icon,
                contentDescription = stepName,
                tint = if (isActive) Color.White else Color.Gray,
                modifier = Modifier.size(18.dp)
            )
        }
        Text(
            text = stepName,
            fontSize = 11.sp,
            fontWeight = if (isActive) FontWeight.Bold else FontWeight.Normal,
            color = if (isActive) stepColor else Color.Gray
        )
    }
}
