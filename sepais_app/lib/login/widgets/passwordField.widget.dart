import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/login/loginView.controller.dart';

class PasswordField extends GetView<LoginController> {
  const PasswordField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField( //campo de texto/digitável
      controller: controller.passwordInput, //passwordInput (loginView.Controller) é onde estará armazenado as informações para controle do passwordField
      decoration: InputDecoration(hintText: 'Senha'),
      obscureText: true,
      
    );
  }
}