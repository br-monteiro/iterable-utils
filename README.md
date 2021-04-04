# Iterable Utils

Esta Lib reúne algumas funções úteis para o tratamento de `arrays`

### Dependências

PHP 7.0+

### Testes
Para rodar os testes unitários basta executar o seguinte comando no terminal

```bash
$ composer test
```

### Métodos disponíveis na biblioteca

- map
- find
- filter
- even
- only
- last
- reduce

### Características comuns dos métodos

Todos os métodos recebem como parâmetro um `Array` e um `callbak`, que é uma função do tipo `callable`. Essa função de callback receberá por padrão como parâmetro o valor do elemento atual do array e seu índice. Por exemplo:

```php
function($value, $index) {
    // sua implementação
}
```

### Método map

O método map(...) é usado nos casos onde precisamos percorrer todo o array e alterar todos ou determinados elementos, de acordo com o callback passado como parâmetro. Abaixo é possível observar algumas formas de uso do método map.
Após a exeução, o `map` retorna um novo `array` com os itens mapeados pela função `callback`

__Sintaxe:__

```php
map(array $arr, callable $callback): Array;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve processar o elemento recebido por parâmetro e retornar o resulta deste processamento.

__retorno__

Retorna um novo array com os elementos processados pelo método, de acordo com o callbak passado por parâmetro.

__Exemplo 01__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    'Gato',
    'Cachorro',
    'Baleia',
    'Elefante',
    'Leão'
];

$newArr = it::map($arr, function($v, $i) {
    $first = substr($v, 0, 1);
    $last = substr($v, -1, 1);
    return "[{$i}]-{$v}: inicia com '{$first}' e finaliza com '{$last}'";
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
array(5) {
  [0]=>
  string(43) "[0]-Gato: inicia com 'G' e finaliza com 'o'"
  [1]=>
  string(47) "[1]-Cachorro: inicia com 'C' e finaliza com 'o'"
  [2]=>
  string(45) "[2]-Baleia: inicia com 'B' e finaliza com 'a'"
  [3]=>
  string(47) "[3]-Elefante: inicia com 'E' e finaliza com 'e'"
  [4]=>
  string(44) "[4]-Leão: inicia com 'L' e finaliza com 'o'"
}
```

__Exemplo 02__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    'Gato',
    'Cachorro',
    'Baleia',
    'Elefante',
    'Leão'
];

$newArr = it::map($arr, function($v) {
    if (preg_match('/^.*o$/', $v)) {
        $v = "{$v}: Termina com 'o'";
    }
    return $v;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
array(5) {
  [0]=>
  string(21) "Gato: Termina com 'o'"
  [1]=>
  string(25) "Cachorro: Termina com 'o'"
  [2]=>
  string(6) "Baleia"
  [3]=>
  string(8) "Elefante"
  [4]=>
  string(22) "Leão: Termina com 'o'"
}
```

### Método find

O método find(...) é usado nos casos onde precisamos econtrar a primeira ocorrência de um elemento, de acordo com o callback passado como parâmetro. Abaixo é possível observar algumas formas de uso do método find.

__Sintaxe:__

```php
find(array $arr, callable $callback): mixed;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve retornar o elemento atual do array se a condição passada por callback for satisfeita.

__retorno__

Retorna um elemento do array, se a condição do callback for satisfeita ou __null__ se nenhum elemento for encontrado.

__Exemplo__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Caminhão', 'rodas' => 'undefined']
];

$newArr = it::find($arr, function($v) {
    return $v['rodas'] == 4;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
array(2) {
  ["tipo"]=>
  string(5) "Carro"
  ["rodas"]=>
  int(4)
}
```

### Método filter

O método filter(...) é usado nos casos onde precisamos filtrar os elementos de uma array de acordo com o callback passado como parâmetro. Abaixo é possível observar algumas formas de uso do método filter.

__Sintaxe:__

```php
filter(array $arr, callable $callback): array;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve retornar um valor booleano, onde __true__ significa que o elemento atual deve fazer parte do novo array (deve passar pelo filtro), e __false__ significa que o elemento atual deve ser descartado.

__retorno__

Retorna um novo array com os elementos filtrados pela condição do callback.

__Exemplo 01__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Monociclo', 'rodas' => 1]
];

$newArr = it::filter($arr, function($v) {
    return $v['rodas'] > 1;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
array(3) {
  [0]=>
  array(2) {
    ["tipo"]=>
    string(5) "Carro"
    ["rodas"]=>
    int(4)
  }
  [1]=>
  array(2) {
    ["tipo"]=>
    string(4) "Moto"
    ["rodas"]=>
    int(2)
  }
  [2]=>
  array(2) {
    ["tipo"]=>
    string(11) "Quadriciclo"
    ["rodas"]=>
    int(4)
  }
}
```

__Exemplo 02__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    'Gato',
    'Cachorro',
    'Baleia',
    'Elefante',
    'Leão'
];

$newArr = it::filter($arr, function($v) {
    return (bool) preg_match('/^.a.*$/', $v);
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
array(3) {
  [0]=>
  string(4) "Gato"
  [1]=>
  string(8) "Cachorro"
  [2]=>
  string(6) "Baleia"
}
```

### Método even

O método even(...) é usado nos casos onde precisamos validar que todos os elementos do array atendem a condição passada no callback.

__Sintaxe:__

```php
even(array $arr, callable $callback): bool;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve retornar um valor booleano, onde __true__ significa que o elemento atual atende a condição, e __false__ significa que o elemento atual não atende.

__retorno__

Retorna __true__ se todos os elementos do array satisfizerem a condição do callback. Retorna __false__ se ao menons um elemento não satisfizer a condição do callback.

__Exemplo 01__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Monociclo', 'rodas' => 1]
];

$newArr = it::even($arr, function($v) {
    return (bool) preg_match('/^.*o$/', $v['tipo']);
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
bool(true)
```

__Exemplo 02__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Monociclo', 'rodas' => 1]
];

$newArr = it::even($arr, function($v) {
    return $v['rodas'] > 1;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
bool(false)
```

### Método only

O método only(...) é usado nos casos onde precisamos validar que **SOMENTE** um dos elementos do array atendem a condição passada no callback.

__Sintaxe:__

```php
only(array $arr, callable $callback): bool;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve retornar um valor booleano, onde __true__ significa que o elemento atual atende a condição, e __false__ significa que o elemento atual não atende.

__retorno__

Retorna __true__ se **APENAS UM** dos elementos do array satisfizer a condição do callback. Retorna __false__ se  mais de um ou nenhum elemento satisfizer a condição do callback.

__Exemplo 01__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Monociclo', 'rodas' => 1]
];

$newArr = it::only($arr, function($v) {
    return $v['rodas'] == 0;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
bool(true)
```

__Exemplo 02__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Monociclo', 'rodas' => 1]
];

$newArr = it::only($arr, function($v) {
    return strlen($v['tipo']) == 5;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
bool(true)
```

### Método last

O método last(...) é usado nos casos onde precisamos econtrar a última ocorrência de um elemento, de acordo com o callback passado como parâmetro. Abaixo é possível observar algumas formas de uso do método last.

__Sintaxe:__

```php
only(array $arr, callable $callback): mixed;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve retornar o elemento atual do array se a condição passada por callback for satisfeita.

__retorno__

Retorna um elemento do array, se a condição do callback for satisfeita ou __null__ se nenhum elemento for encontrado.

__Exemplo__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = [
    ['tipo' => 'Barco', 'rodas' => 0],
    ['tipo' => 'Carro', 'rodas' => 4],
    ['tipo' => 'Moto', 'rodas' => 2],
    ['tipo' => 'Quadriciclo', 'rodas' => 4],
    ['tipo' => 'Caminhão', 'rodas' => 'undefined']
];

$newArr = it::last($arr, function($v) {
    return $v['rodas'] == 4;
});

var_dump($newArr);
```

A saída da execução acima se parece com o seguinte

```bash
array(2) {
  ["tipo"]=>
  string(5) "Quadriciclo"
  ["rodas"]=>
  int(4)
}
```


### Método reduce

O método reduce(...) executa uma função `reducer` (callback) para cada elemento do array, resultando num único valor de retorno. Abaixo é possível observar algumas formas de uso do método reduce.

__Sintaxe:__

```php
reduce(array $arr, callable $callback, $default): mixed;
```

__$arr__

Array a ser usado pelo método

__$callback__

Esta função deve retornar o resultado da lógica de redução aplicada no elemento corrente do array. Esta função recebe três parâmetros:
 - `$acc`: valor das reduções anteriores
 - `$value`: valor do elemento corrente
 - `$index`: valor do index do elemento corrente

__$default__

Valor padrão de entrada para `$acc`. Caso a lógica não seja aplicada a nenhum elemento do array, este valor será retornado por padrão. Caso não seja passado nenhum valor para este parâmetro, então `null` é considerado como padrão.

__retorno__

Deve retornar o valor da redução aplicada pela lógica do callback.

__Exemplo__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = ['h', 'e', 'i', 't', 'o', 'r'];

$result = it::reduce($arr, function($acc, $value) {
    return $acc . strtoupper($value);
});

var_dump($result);
```

A saída da execução acima se parece com o seguinte

```bash
string(6) "HEITOR"
```

__Exemplo__

```php
use HTR\Utils\Iterables\IterableUtils as it;

$arr = ['h', 'e', 'i', 't', 'o', 'r'];

$result = it::reduce($arr, function($acc, $value, $index) {
    if (in_array($value, ['h', 't', 'r'])) {
        $acc .= $index . '-' . strtoupper($value);
    }
    return $acc;
});

var_dump($result);
```

A saída da execução acima se parece com o seguinte

```bash
string(9) "0-H3-T5-R"
```

### Créditos
Esta biblioteca foi desenvolvida por [Edson B S Monteiro](mailto:bruno.monteirodg@gmail.com) como treinamento de TDD com PHP.

## LAUS DEO .'.