import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/assets/preguica.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class RegisterButton extends GetView<RegisterController> {
  const RegisterButton({super.key});

  @override
  Widget build(BuildContext context) {
    return ElevatedButton(
      onPressed: () {},
      child: Text('Criar conta'),
      style: ButtonStyle(
          backgroundColor: WidgetStateProperty.all<Color>(verdepica())),
    );
  }
}
