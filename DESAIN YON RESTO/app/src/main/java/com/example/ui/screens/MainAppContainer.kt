package com.example.ui.screens

import androidx.compose.animation.*
import androidx.compose.foundation.BorderStroke
import androidx.compose.foundation.background
import androidx.compose.foundation.border
import androidx.compose.foundation.clickable
import androidx.compose.foundation.layout.*
import androidx.compose.foundation.shape.RoundedCornerShape
import androidx.compose.material.icons.Icons
import androidx.compose.material.icons.filled.*
import androidx.compose.material.icons.outlined.*
import androidx.compose.material3.*
import androidx.compose.runtime.*
import androidx.compose.ui.Alignment
import androidx.compose.ui.Modifier
import androidx.compose.ui.draw.clip
import androidx.compose.ui.graphics.Color
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.dp
import androidx.compose.ui.unit.sp
import com.example.viewmodel.RestoViewModel

enum class UserRole(val label: String, val icon: androidx.compose.ui.graphics.vector.ImageVector) {
    CUSTOMER("😋 Pelanggan", Icons.Default.Person),
    KITCHEN("🍳 Dapur (KDS)", Icons.Default.SoupKitchen),
    POS("🛒 Cashier (POS)", Icons.Default.PointOfSale),
    ADMIN("📈 Admin (Stats)", Icons.Default.AdminPanelSettings)
}

@Composable
fun MainAppContainer(
    viewModel: RestoViewModel,
    modifier: Modifier = Modifier
) {
    var currentRole by remember { mutableStateOf(UserRole.CUSTOMER) }
    var customerTab by remember { mutableStateOf(0) } // 0: Menu, 1: Cart, 2: Track

    val cartItems by viewModel.cartItems.collectAsState()
    val cartSize = cartItems.sumOf { it.quantity }

    Box(
        modifier = modifier
            .fillMaxSize()
            .background(MaterialTheme.colorScheme.background)
    ) {
        Column(modifier = Modifier.fillMaxSize()) {
            // Master Role Switcher Banner - allows experiencing any screen combination
            Card(
                colors = CardDefaults.cardColors(
                    containerColor = if (currentRole == UserRole.KITCHEN) Color(0xFF0F172A) else Color.White
                ),
                shape = RoundedCornerShape(bottomStart = 24.dp, bottomEnd = 24.dp),
                border = BorderStroke(1.dp, Color.LightGray.copy(alpha = 0.2f)),
                elevation = CardDefaults.cardElevation(defaultElevation = 6.dp),
                modifier = Modifier
                    .fillMaxWidth()
                    .statusBarsPadding()
            ) {
                Column(modifier = Modifier.padding(horizontal = 16.dp, vertical = 10.dp)) {
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.SpaceBetween,
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        Text(
                            text = "MODE PREVIEW SIMULASI",
                            fontSize = 9.sp,
                            fontWeight = FontWeight.Black,
                            letterSpacing = 1.sp,
                            color = if (currentRole == UserRole.KITCHEN) Color.Gray else Color.LightGray
                        )

                        // Mode chip label indicator
                        Box(
                            modifier = Modifier
                                .clip(RoundedCornerShape(6.dp))
                                .background(MaterialTheme.colorScheme.primary.copy(alpha = 0.1f))
                                .padding(horizontal = 8.dp, vertical = 2.dp)
                        ) {
                            Text(
                                text = "TAP TO CHOOSE WINDOW",
                                fontSize = 8.sp,
                                fontWeight = FontWeight.Bold,
                                color = MaterialTheme.colorScheme.primary
                            )
                        }
                    }

                    Spacer(modifier = Modifier.height(4.dp))

                    // Row layout selectors
                    Row(
                        modifier = Modifier.fillMaxWidth(),
                        horizontalArrangement = Arrangement.spacedBy(4.dp),
                        verticalAlignment = Alignment.CenterVertically
                    ) {
                        UserRole.values().forEach { role ->
                            val isSelected = currentRole == role
                            Box(
                                modifier = Modifier
                                    .weight(1f)
                                    .clip(RoundedCornerShape(12.dp))
                                    .clickable {
                                        currentRole = role
                                        // Reset corresponding tabs on switch
                                        if (role == UserRole.CUSTOMER) customerTab = 0
                                    }
                                    .background(
                                        if (isSelected) MaterialTheme.colorScheme.primary else Color.Transparent
                                    )
                                    .padding(vertical = 10.dp, horizontal = 4.dp),
                                contentAlignment = Alignment.Center
                            ) {
                                Column(horizontalAlignment = Alignment.CenterHorizontally) {
                                    Icon(
                                        imageVector = role.icon,
                                        contentDescription = role.label,
                                        tint = if (isSelected) Color.White else (if (currentRole == UserRole.KITCHEN) Color.LightGray else Color.Gray),
                                        modifier = Modifier.size(16.dp)
                                    )
                                    Spacer(modifier = Modifier.height(2.dp))
                                    Text(
                                        text = role.label,
                                        color = if (isSelected) Color.White else (if (currentRole == UserRole.KITCHEN) Color.LightGray else Color.DarkGray),
                                        fontWeight = FontWeight.Bold,
                                        fontSize = 9.sp,
                                        maxLines = 1
                                    )
                                }
                            }
                        }
                    }
                }
            }

            // Container for dynamic screen structures based on role select
            Box(
                modifier = Modifier
                    .fillMaxSize()
                    .weight(1f)
            ) {
                when (currentRole) {
                    UserRole.CUSTOMER -> {
                        when (customerTab) {
                            0 -> CustomerScreen(
                                viewModel = viewModel,
                                onNavigateToCart = { customerTab = 1 }
                            )
                            1 -> CartScreen(
                                viewModel = viewModel,
                                onNavigateToTrack = { customerTab = 2 }
                            )
                            2 -> TrackScreen(
                                viewModel = viewModel
                            )
                        }
                    }
                    UserRole.KITCHEN -> KdsScreen(viewModel = viewModel)
                    UserRole.POS -> PosScreen(viewModel = viewModel)
                    UserRole.ADMIN -> AdminScreen(viewModel = viewModel)
                }
            }

            // Bottom Nav bar is shown ONLY for Customer role mode to preserve spacing and focus
            AnimatedVisibility(
                visible = currentRole == UserRole.CUSTOMER,
                enter = slideInVertically(initialOffsetY = { it }) + fadeIn(),
                exit = slideOutVertically(targetOffsetY = { it }) + fadeOut()
            ) {
                NavigationBar(
                    containerColor = Color.White,
                    tonalElevation = 8.dp,
                    modifier = Modifier.navigationBarsPadding()
                ) {
                    // TAB 1: MENU
                    NavigationBarItem(
                        selected = customerTab == 0,
                        onClick = { customerTab = 0 },
                        icon = {
                            Icon(
                                imageVector = if (customerTab == 0) Icons.Filled.RestaurantMenu else Icons.Outlined.RestaurantMenu,
                                contentDescription = "Menu"
                            )
                        },
                        label = { Text("Menu Home", fontWeight = FontWeight.Bold, fontSize = 11.sp) },
                        colors = NavigationBarItemDefaults.colors(
                            selectedIconColor = MaterialTheme.colorScheme.primary,
                            selectedTextColor = MaterialTheme.colorScheme.primary
                        )
                    )

                    // TAB 2: CART (with real-time badges!)
                    NavigationBarItem(
                        selected = customerTab == 1,
                        onClick = { customerTab = 1 },
                        icon = {
                            BadgedBox(
                                badge = {
                                    if (cartSize > 0) {
                                        Badge(
                                            containerColor = MaterialTheme.colorScheme.primary
                                        ) {
                                            Text(cartSize.toString(), color = Color.White, fontWeight = FontWeight.Bold)
                                        }
                                    }
                                }
                            ) {
                                Icon(
                                    imageVector = if (customerTab == 1) Icons.Filled.ShoppingBag else Icons.Outlined.ShoppingBag,
                                    contentDescription = "Cart"
                                )
                            }
                        },
                        label = { Text("Keranjang", fontWeight = FontWeight.Bold, fontSize = 11.sp) },
                        colors = NavigationBarItemDefaults.colors(
                            selectedIconColor = MaterialTheme.colorScheme.primary,
                            selectedTextColor = MaterialTheme.colorScheme.primary
                        )
                    )

                    // TAB 3: ACTIVE TRACKER
                    NavigationBarItem(
                        selected = customerTab == 2,
                        onClick = { customerTab = 2 },
                        icon = {
                            Icon(
                                imageVector = if (customerTab == 2) Icons.Filled.DirectionsRun else Icons.Outlined.DirectionsRun,
                                contentDescription = "Track"
                            )
                        },
                        label = { Text("Lacak", fontWeight = FontWeight.Bold, fontSize = 11.sp) },
                        colors = NavigationBarItemDefaults.colors(
                            selectedIconColor = MaterialTheme.colorScheme.primary,
                            selectedTextColor = MaterialTheme.colorScheme.primary
                        )
                    )
                }
            }
        }
    }
}
