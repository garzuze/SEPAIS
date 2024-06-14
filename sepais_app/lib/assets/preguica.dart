import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:get/get.dart';

Color verdepica() {
  return Color.fromRGBO(0, 191, 99, 1);
}

class AppbarSepais {
  appbar() {

    return AppBar(
        backgroundColor: verdepica(),
        centerTitle: true,
        flexibleSpace: Center(
          child: Stack(
            alignment: Alignment.center,
            children: [

               SizedBox(
                width: Get.width,
                height: Get.height,

                 child: SvgPicture.asset(
                  'lib/assets/wave.svg',
                  fit: BoxFit.fill,
                               ),
               ),

              Image.asset(
                'lib/assets/sepais_logo_2.png',
                width: 200,
                height: 200,
                fit: BoxFit.contain,
              ),
            ],
          ),
        ));
  }
}
          // child: SvgPicture.asset('wave.svg'),