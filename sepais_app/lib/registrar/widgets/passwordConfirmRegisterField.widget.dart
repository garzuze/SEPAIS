import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class PasswordConfirmRegisterField extends GetView<RegisterController> {
  const PasswordConfirmRegisterField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller.passwordRegisterConfirmInput,
      decoration: InputDecoration(hintText: 'Senha'),
      obscureText: true,
      
    );
  }
}