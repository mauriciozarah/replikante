<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)
- [云软科技](http://www.yunruan.ltd/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

#######################################################################################################
## Instalando o JWT
## 1.) Na pasta do projeto pelo terminal digitar:  composer require tymon/jwt-auth ^1.0.0
## 2.) No arquivo config/app.php  Inserir -> 'providers' => [Tymon\JWTAuth\Providers\LaravelServiceProvider::class,]
## 3.) Publicando as configurações: na linha de comando: php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider" - enter
## 4.) Gerando chave: na  linha de comando: php artisan jwt:secret - ele vai escrever no .env o JWT_SECRET
## 5.) Na User.php que é gerado com o migrate fazer => antes do inicio da classe: "use Tymon\JWTAuth\Contracts\JWTSubject" e => class User extends Authenticatable implements JWTSubject.
##     - Como a implementação("implements") não contém 2 funções necessárias, é necessário colar 2 funções dentro da class User. => 
##     - inserir dentro da class User -> public function getJWTIdentifier(){ return $this->getKey(); } e também -> public function getJWTCustomClaims(){ return []; }
## 6.) No arquivo: config/auth.php procurar a linha 'guards' =-> [ 'web' => ['driver' => 'session', 'provider' => 'users'], 'api' => ['driver' => 'jwt', 'provider' => ' 'users', 'hash' => false,], ], ->      trocar o 'driver' => 'token' ##     para 'driver' => 'jwt'
## 7.) Criar o controller -> php artisan make:controller Api\\AuthController -> criar a função login pode conferir em App -> Http -> COntrollers -> Api -> AuthCOntroller
## 8.) criar a função protegida respondWithToken($token) -> está em Api\\AuthController
## 9.) Na rota está : routes/api.php -> criar a rota: Route::post('auth/login', 'Api\\AuthController@login'); = acessar via post com 'login' e 'password' -> pode ser via postman
## 10.) Criar um middleware : na linha de comando fica : php artisan make:middleware apiProtectedRoute, será criada dentro da pasta HTTP/Middleware
## 11.) Fazer a classe apiProtectedRoute extender da classe BaseMiddleware, no topo do arquivo colocar : use Tymon\JWTAuth\Http\Middleware\BaseMiddleware; verificar que a classe extends BaseMiddleware. Obs.: Ver arquivo apiProtectedRoute dentro de middleware as implementações
## 12.) Em App -> Http -> Kernel.php inserir um apelido para o arquivo apiProtectedRoute. => protected $routeMiddleware = ['apiJwt' =>         \App\Http\Middleware\apiProtectedRoute::class,] -> acrescentar um apelido, no caso apiJwt, dentro do vetor $routeMiddleware
## 13.) A partir de agora podemos proteger as rotas. Verificar routes/api.php -> temos a rota post para faze login e a rota protegida get users. Basicamente é fazer login, pegar o token, e depois usar o token para acessar a rota get de users
#######################################################################################################


#############################################################
##
## Instalando o JWT
## composer require tymon/jwt-auth 1.0.0-rc.5
##
#############################################################

## php artisan migrate
## php artisan db:seed
## login: bruno@mail.com
## senha: 123





