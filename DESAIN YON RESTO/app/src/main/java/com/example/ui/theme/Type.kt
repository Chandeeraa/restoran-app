package com.example.ui.theme

import androidx.compose.material3.Typography
import androidx.compose.ui.text.TextStyle
import androidx.compose.ui.text.font.FontFamily
import androidx.compose.ui.text.font.FontWeight
import androidx.compose.ui.unit.sp

// Geometric Typography matching Modern Fluid-Memphis "Outfit" guidelines
val Typography = Typography(
  displayLarge = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.Black, // 900
    fontSize = 48.sp,
    lineHeight = 56.sp,
    letterSpacing = (-0.02).sp
  ),
  displayMedium = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.ExtraBold, // 800
    fontSize = 36.sp,
    lineHeight = 44.sp,
    letterSpacing = (-0.01).sp
  ),
  headlineLarge = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.Bold, // 700
    fontSize = 24.sp,
    lineHeight = 32.sp,
    letterSpacing = (-0.01).sp
  ),
  headlineMedium = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.Bold, // 700
    fontSize = 20.sp,
    lineHeight = 28.sp,
    letterSpacing = (-0.01).sp
  ),
  bodyLarge = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.Normal, // 400
    fontSize = 16.sp,
    lineHeight = 24.sp
  ),
  bodyMedium = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.Medium, // 500
    fontSize = 16.sp,
    lineHeight = 24.sp
  ),
  labelLarge = TextStyle(
    fontFamily = FontFamily.SansSerif,
    fontWeight = FontWeight.Bold, // 700
    fontSize = 12.sp,
    lineHeight = 16.sp,
    letterSpacing = 0.05.sp
  )
)
