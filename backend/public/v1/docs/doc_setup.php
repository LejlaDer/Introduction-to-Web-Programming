<?php
/**
 * @OA\Info(
 *     title="BizConnect API",
 *     version="1.0.0",
 *     description="Business Events API for managing events, venues, and organizers",
 *     @OA\Contact(
 *         email="derviseviclejla3@gmail.com",
 *         name="Lejla Dervišević"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost/BizConnect/backend",
 *     description="Development server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */