import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/assets/preguica.dart';
import 'package:sepais/login/loginView.controller.dart';

class LoginButton extends GetView<LoginController> {
  const LoginButton({super.key});

  @override
  Widget build(BuildContext context) {
    return ElevatedButton(onPressed: () {controller.tryLogin();
    },
    child: const Text('Entrar'),
    style: ButtonStyle(backgroundColor: WidgetStateProperty.all<Color>(verdepica())),
    
    );
  }
}