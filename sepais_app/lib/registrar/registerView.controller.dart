import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:sepais/login/login.view.dart';

class RegisterController extends GetxController{
  TextEditingController nameRegisterInput = TextEditingController(); 
  TextEditingController cpfRegisterInput = TextEditingController();
  TextEditingController emailRegisterInput = TextEditingController(); 
  TextEditingController passwordRegisterInput = TextEditingController();
  TextEditingController passwordRegisterConfirmInput = TextEditingController();


  // void tryRegister(){
  //   if()
  // }

  void register (){
    Get.to(LoginView());
  }
}