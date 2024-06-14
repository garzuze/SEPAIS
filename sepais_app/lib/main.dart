import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/bindings.dart';
import 'package:sepais/login/login.view.dart';
// import 'package:flutter_svg/flutter_svg.dart';

void main() {
  runApp(MyApp());
}
class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {

    return GetMaterialApp(
      initialBinding: InitialBindings(),
      debugShowCheckedModeBanner: false,
      home: const LoginView(), //a página 'home' do app é a de Login.
    );
  }
}

