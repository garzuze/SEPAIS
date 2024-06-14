import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class CpfRegisterField extends GetView<RegisterController> {
  const CpfRegisterField({super.key});

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller.cpfRegisterInput,
      decoration: InputDecoration(hintText: 'CPF'),
    );
  }
}