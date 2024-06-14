import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/login/loginView.controller.dart';

class EmailField extends GetView<LoginController> {
  const EmailField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller.emailInput, //emailInput (loginView.Controller) é onde estará armazenado as informações para controle do emailField
      decoration: InputDecoration(hintText: 'Email'),
    );
  }
}