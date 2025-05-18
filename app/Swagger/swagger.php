<?php

/**
 * @OA\Info(
 *     title="API Prueba Soluciones Fourgen",
 *     version="1.0",
 *     description="API para la prueba técnica de Soluciones Fourgen, donde se podran verificar los diferentes endpoints relacionados con la autenticación, manejo de personas y sus mascotas"
 * )
 *
 * @OA\Server(
 *     url="http://prueba-soluciones-fourgen.test"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
