import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class PasswordRegisterField extends GetView<RegisterController> {
  const PasswordRegisterField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller.passwordRegisterInput,
      decoration: InputDecoration(hintText: 'Confirme sua senha'),
      obscureText: true,
    );
  }
}