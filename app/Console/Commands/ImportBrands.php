<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Brand;
use App\Style;
use App\Type;

class ImportBrands extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'import:brands';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct ()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle ()
	{
		$file = fopen(base_path().'/storage/app/csvs/brands.csv', 'r');

		$headers = ['Brand', 'Model', 'Type'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$brand = Brand::where('name', $row['Brand'])->first();

			if (count($brand) == 0) {
				$brand = new Brand;
				$brand->name = $row['Brand'];
				$brand->save();
			}

			$type = Type::where('name', $row['Type'])->first();

			if (count($type) == 0) {
				$type = new Type;
				$type->name = $row['Type'];
				$type->save();
			}

			$this->info($brand);
			$this->info($type);

			$style = new Style;
			$style->brand_id = $brand->id;
			$style->type_id = $type->id;
			$style->name = $row['Model'];
			$style->save();

			$this->info('id:' . $style->id . ' brand_id:' . $brand->id . ' type_id:' . $type->id);
		}

		fclose($file);
	}

}
