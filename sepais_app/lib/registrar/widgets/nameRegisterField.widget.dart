import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class NameRegisterField extends GetView<RegisterController> {
  const NameRegisterField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller.nameRegisterInput,
      decoration: InputDecoration(hintText: 'Nome Completo'),
      
    );
  }
}