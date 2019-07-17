# Laravel DTO
   
Laravel에서 데이터를 DTO class에 맵핑시킬 수 있는 컴포저   
Request 데이터 DTO 클래스에 자동 맵핑시켜주는 provider 제공


## 설치
### Composer
satis.gabia.com `composer.json` 레파지토리 등록 필요
```shell
composer install gabia/laravel-dto 
```

### Larvel Provider 추가
`config/app.php` 파일에 provider 추가
```php
'providers' => [
    
    // .... 생략 ....
    
    // Request/DTO class mapping Provider
    Gabia\LaravelDto\LaravelDtoProvider::class,
]
````

## 사용법
### DTO 클래스 생성
#### Jsonmapper 방식 DTO 클래스
LaravelDto 인터페이스 구현한 DTO 클래스 생성   
setter, getter 메소드가 필요하기 때문에 IDE 사용 권장
```php
use Gabia\LaravelDto\Dto\LaravelDto;

class TestDto implements LaravelDto
{
    /**
     * @var string|null
     */
    private $goods;

    /**
     * @var string|null
     */
    private $group;

    /**
     * @var string|null
     */
    private $package;

    /**
     * @return null|string
     */
    public function getGoods(): ?string
    {
        return $this->goods;
    }

    /**
     * @param null|string $goods
     */
    public function setGoods(?string $goods): void
    {
        $this->goods = $goods;
    }
    
    // .... 생략 ....
}    
```

### DTO 클래스 사용
#### Controller에서 사용
Laravel 프레임워크에서 auto injection 지원하는 controller에서 DTO 클래스 사용
> Request의 경우 provider에서 자동 맵핑 시켜줌
```php
namespace App\Http\Controllers;

class GoodsController extends Controller
{
    public function testMethod(TestDto $request_dto)
    {
        $goods = $request_dto->getGoods();
    }
}
```

#### 수동 맵핑 사용
array, json 데이터를 수동으로 DTO 서비스를 통해 클래스에 맵핑하여 사용
```php
$data = [
    "goods" => 'TEST GOODS'
];   

$dto_service = new DtoService();

$dto = $dto_service->createDto('\Dto\TestDto', $data);

$goods = $dto->getGoods(); // TEST GOODS
```

#### DTO 클래스 배열 변환
DTO 클래스 데이터 배열 변환 기능
```php
$dto_service = new DtoService();

// DTO 인스턴스
$dto = $dto_service->createDto('\Dto\TestDto', $data);

// 배열 변환
$array = $dto_service->toArray($dto);
```


 
## Mapper
##### 데이터를 class에 맵핑시켜주는 맵퍼
### Jsonmapper
  - 현재 유일한 맵퍼
  - 모든 데이터를 json 인코딩한 후 클래스에  맵핑
  - [Jsonmapper](https://github.com/cweiske/jsonmapper) 컴포저 사용