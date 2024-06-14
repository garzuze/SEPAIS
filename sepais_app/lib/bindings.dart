import 'package:get/get.dart';
import 'package:sepais/login/loginView.controller.dart';
import 'package:sepais/registrar/registerView.controller.dart';

class InitialBindings extends Bindings{
  @override
  void dependencies() {
    Get.lazyPut(() => RegisterController()); //chama uma vez só o controlador e descarta (lazyPut)
    Get.lazyPut(() => LoginController()); //chama uma vez só o controlador e descarta (lazyPut)

  }
}