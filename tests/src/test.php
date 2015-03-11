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

	public function testForget(){
		$this->collection->forget(0);
		$this->assertEquals(3, $this->collection->count());
		$this->assertEquals(16, $this->collection->sum());

		$this->collection->forget(3);
		$this->assertEquals(2, $this->collection->count());
		$this->assertEquals(10, $this->collection->sum());
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

	public function testPaginate(){
		$collection = new Collection(array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14));

		$pag1 = $collection->paginate(1, 5);
		$pag2 = $collection->paginate(2, 5);
		$pag3 = $collection->paginate(3, 5);

		$this->assertEquals(5, $pag1->count());
		$this->assertEquals(5, $pag2->count());
		$this->assertEquals(4, $pag3->count());

		$this->assertEquals(15, $pag1->sum());
		$this->assertEquals(40, $pag2->sum());
		$this->assertEquals(50, $pag3->sum());
	}

	public function testIsEmpty(){
		$this->assertFalse($this->collection->isEmpty());
		$this->assertTrue((new Collection())->isEmpty());
	}

	public function testReverse(){
		$reverse = $this->collection->reverse();
		$items   = $reverse->toArray();

		$this->assertEquals(6, $items[0]);
		$this->assertEquals(2, $items[1]);
		$this->assertEquals(8, $items[2]);
		$this->assertEquals(4, $items[3]);
	}

	public function testOffsetExists(){
		$this->assertFalse($this->collection->offsetExists(8));
		$this->assertTrue($this->collection->offsetExists(2));
	}

	public function testOffsetGet(){
		$this->assertEquals(4, $this->collection->OffsetGet(0));
		$this->assertEquals(6, $this->collection->OffsetGet(3));
	}

	public function testGet(){
		$this->assertEquals(4, $this->collection->get(0));
		$this->assertEquals(6, $this->collection->get(3));
	}	

	public function testGetWithDefault(){
		$this->assertEquals(35, $this->collection->get(6, 35));
	}

	public function testAll(){
		$this->assertInternalType('array', $this->collection->all());
		$this->assertEquals(4, count($this->collection->all()));
		$this->assertEquals(20, array_sum($this->collection->all()));
	}

	public function testFirst(){
		$this->assertEquals(4, $this->collection->first());
	}
	
}