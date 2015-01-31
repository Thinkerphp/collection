<?php 

use Thinkerphp\Collection;

class CollectionTest extends \PHPUnit_Framework_Testcase{

	private $collection;

	public function __construct(){
		$this->collection = new Collection(array(4, 8, 2, 6));
	}

	public function testMap(){		

		$map = $this->collection->map(function($data){
			return $data * 2;
		});

		$this->assertInstanceOf('Thinkerphp\Collection', $map);
		$this->assertEquals(4, count($map->toArray()));
		$this->assertEquals(40, array_sum($map->toArray()));
	}

	public function testFilter(){
		$filter = $this->collection->filter(function($item){
			return $item > 5;
		});

		$this->assertInstanceOf('Thinkerphp\Collection', $filter);
		$this->assertEquals(2, count($filter->toArray()));
		$this->assertEquals(14, array_sum($filter->toArray()));
	}

	public function testSort(){
		$this->collection->sort(function ($a, $b){
			if ($a==$b) 
				return 0;
			return ($a<$b)?-1:1;
		});

		$items = $this->collection->toArray();

		$this->assertEquals(2, $items[0]);
		$this->assertEquals(4, $items[1]);
		$this->assertEquals(6, $items[2]);
		$this->assertEquals(8, $items[3]);
	}

	public function testPop(){
		$pop = $this->collection->pop();
		$this->assertEquals(6, $pop);
	}

	public function testSum(){
		$this->assertEquals(20, $this->collection->sum());
	}

	public function testSumCollectionOfArrays(){
		$collection = new Collection(array(
			array(
				'product' => 'Shoes',
				'total' => 12
			),
			array(
				'product' => 'Hat',
				'total' => 10
			),
			array(
				'product' => 'Shirt',
				'total' => 3
			)
		));

		$this->assertEquals(25, $collection->sum(function($value){
			return $value['total'];
		}));
	}

	public function testCount(){
		$this->assertEquals(4, $this->collection->count());
	}

}