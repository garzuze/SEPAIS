import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class EmailRegisterField extends GetView<RegisterController> {
  const EmailRegisterField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller.emailRegisterInput,
      decoration: InputDecoration(hintText: 'Email'),
      
    );
  }
}