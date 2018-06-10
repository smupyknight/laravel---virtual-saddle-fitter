<?php

namespace App\Console\Commands;

use App\Client;
use App\Horse;
use App\Saddle;
use App\FitCheck;
use App\Rider;
use Carbon\Carbon;
use \DateTime;
use Illuminate\Console\Command;
use \Excel;
use App\ClientFitter;

class ImportData extends Command
{

	private $bar;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'importdata {fitter_id}';

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
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		Excel::load(base_path() . '/storage/app/csvs/data.xls', function($reader) {
			$reader->each(function($sheet) {
				if ($sheet->getTitle() == 'Time') {
					return;
				}

				$this->bar = $this->output->createProgressBar(count($sheet));
				$this->bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");

				$this->importClients($sheet);
			});

			$reader->each(function($sheet) {
				if ($sheet->getTitle() == 'Time') {
					return;
				}

				$this->bar = $this->output->createProgressBar(count($sheet));
				$this->bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");

				$this->importRiders($sheet);
			});

			$reader->each(function($sheet) {
				if ($sheet->getTitle() == 'Time') {
					return;
				}

				$this->bar = $this->output->createProgressBar(count($sheet));
				$this->bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");

				$this->importHorses($sheet);
			});
//
//			$reader->each(function($sheet) {
//				if ($sheet->getTitle() == 'Time') {
//					return;
//				}
//				$this->bar = $this->output->createProgressBar(count($sheet));
//				$this->bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");
//
//				$this->importFitChecks($sheet);
//			});
		});

		$this->bar->finish();
	}

	private function importClients($sheet)
	{
		$this->bar->setMessage('Importing Clients from Sheet: ' . $sheet->getTitle());

		$sheet->each(function($row) {
			if (empty($row->name)) {
				return;
			}

			$client = Client::firstOrNew(['name' => $row->name]);

			$client->name = ucwords(strtolower($row->name));
			$client->address = ucwords(strtolower($row->owners_address)) ?: '';
			$client->suburb = ucwords(strtolower($row->suburb)) ?: '';
			$client->postcode = $row->postcode ?: '';
			$client->state = $this->getStateFromPostcode($row->postcode) ?: '';

			$client->save();

			if (!$client->fitters()->where('fitter_id', $this->argument('fitter_id'))->exists()) {
				$client_fitter = new ClientFitter;
				$client_fitter->client_id = $client->id;
				$client_fitter->fitter_id = $this->argument('fitter_id');
				$client_fitter->save();
			}

			$this->bar->advance();
		});
	}

	private function importRiders($sheet)
	{
		$this->bar->setMessage('Importing Riders from Sheet: ' . $sheet->getTitle());

		$sheet->each(function($row) {
			if (empty($row->name)) {
				return;
			}

			$rider = Rider::firstOrNew(['mobile' => $row->mobile]);
			$client = Client::where('name', $row->name)->first();

			$name = $this->formatName($row->name);

			$rider->client_id = $client->id;
			$rider->email = $row->email_address ? $row->email_address : '';
			$rider->first_name = ucwords(strtolower($name[0]));
			$rider->last_name = ucwords(strtolower($name[1]));
			$rider->address = ucwords(strtolower($row->owners_address)) ?: '';
			$rider->suburb = ucwords(strtolower($row->suburb)) ?: '';
			$rider->postcode = $row->postcode ?: '';
			$rider->state = $this->getStateFromPostcode($row->postcode) ?: '';
			$rider->mobile = $row->mobile ?: '';

			$rider->save();

			$this->bar->advance();
		});
	}

	private function importHorses($sheet)
	{
		$this->bar->setMessage('Importing Horses from Sheet: ' . $sheet->getTitle());

		$sheet->each(function($row) {
			if (empty($row->horses_name)) {
				return;
			}

			if (empty($row->name)) {
				return;
			}

			$horse = Horse::firstOrNew(['stable_name' => $row->horses_name]);
			$client = Client::where('name', $row->name)->first();

			$horse->client_id = $client->id;
			$horse->stable_name = ucwords(strtolower($row->horses_name));
			$horse->paddock_address = ucwords(strtolower($row->horses_paddock_address)) ?: '';
			$horse->suburb = ucwords(strtolower($row->suburb)) ?: '';
			$horse->postcode = $row->postcode ?: '';
			$horse->state = $this->getStateFromPostcode($row->postcode) ?: '';
			$horse->breed = ucwords(strtolower($row->breed)) ?: '';
			$horse->colour = strtolower($row->colour) ?: '';
			$horse->height = $row->height ?: '';
			$horse->weight = $row->weight ?: '';
			$horse->girth = $row->girth_width ?: '';
			$horse->age = $row->age ?: '';
			$horse->discipline = ucwords(strtolower($row->discipline)) ?: '';
			$horse->sex = $this->getHorseGender($row->sex);

			$horse->save();

			$this->bar->advance();
		});
	}

	private function importFitChecks($sheet)
	{
		$this->bar->setMessage('Importing FitChecks from Sheet: ' . $sheet->getTitle());

		$sheet->each(function($row) {
			if (empty($row->horses_name) || !DateTime::createFromFormat('d/m/Y', $row->date_of_fit)) {
				return;
			}

//			$fitcheck = FitCheck::where('created_at', '<=',
//				Carbon::createFromFormat('d/m/Y', $row->date_of_fit))
//				->where()
//				->firstOrNew();
			$name = $this->formatName($row->name);
			$rider = Rider::where('first_name', $name[0])->where('last_name', $name[1])->first();
			$horse = Horse::where('stable_name', $row->horses_name)->first();

			$fitcheck->rider_id = $rider->id;
			$fitcheck->horse_id = $horse->id;
			$fitcheck->saddle_id = Saddle::where('horse_id', $horse->id)->first()->id ?: '';

			$fitcheck->setSaddleBalanceAttribute($row->saddle_balance ?: '');
			$fitcheck->setPommelClearanceAttribute($row->pommel_clearance ?: '');
			$fitcheck->setTreeMatchAtWitherAttribute($row->tree_match_at_wither ?: '');
			$fitcheck->setTreeMatchAtArcOfSpineAttribute($row->match_with_rac_of_spine ?: '');
			$fitcheck->setChannelDepthAttribute($row->channel_depth ?: '');
			$fitcheck->setChannelWidthAttribute($row->channel_width ?: '');
			$fitcheck->setContoursOfPanelAttribute($row->contours_of_panel ?: '');
			$fitcheck->setMovementWhenSaddledNoRiderAttribute($row->horse_in_motion_no_rider ?: '');
			$fitcheck->setDropsToAttribute($row->rider_drops_lr ?: '');
			$fitcheck->setSitsOffCentreAttribute($row->rider_sits_off_centre_Lr ?: '');
			$fitcheck->setSitsUprightAttribute($row->rider_sits_uprightleans ?: '');
			$fitcheck->setFatCoverAttribute($row->fat_cover_1_thin_6_fat ?: '');
			$fitcheck->setMusclingAttribute($row->muscling ?: '');
			$fitcheck->setBackLengthAttribute($row->back_length ?: '');
			$fitcheck->setBackAngleAttribute($row->uphill_downhill ?: '');
			$fitcheck->setFeetLengthAttribute($row->feet_length ?: '');
			$fitcheck->setShoeingStatusAttribute($row->shoeing_status ?: '');
			$fitcheck->setFootBalanceAttribute($row->foot_balance ?: '');
			$fitcheck->setWitherShapeAttribute($row->withers ?: '');
			$fitcheck->setShoulderAttribute($row->shoulder_blade ?: []);
			$fitcheck->setFlockingBackAttribute($row->back_abnormalities); // ?
			$fitcheck->setMuscleWastageAttribute($row->muscle_wastage_under_saddle ?: []);
			// TODO: $row->muscle_loss
			$fitcheck->setAbdomenAttribute($row->abdomen ?: '');
			$fitcheck->setPointOfHipTuberCoxaeAttribute($row->point_of_hip_tuber_coxae ?: '');
			$fitcheck->setSorenessAttribute($row->soreness ?: []);
			$fitcheck->setReducedFlexibilityAttribute($row->reduced_flexibility ?: []);
			$fitcheck->setPalationFindingsAttribute($row->palation_findings ?: []);
			$fitcheck->setHairChangesAttribute($row->hair_changes ?: '');
			// TODO: $row->girth_pain
			// TODO: $row->saddle_aleterations_required_special_comments
			$fitcheck->setAlterationsAttribute([]);
			$fitcheck->setHistoryOfAlterationsAttribute([]);
			$fitcheck->setRecommendedProductsAttribute([]);

			$fitcheck->save();

			$this->bar->advance();
		});
	}

	private function getStateFromPostcode($postcode)
	{
		$ranges = [
			'NSW' => [
				1000, 1999,
				2000, 2599,
				2619, 2898,
				2921, 2999
			],
			'ACT' => [
				200, 299,
				2600, 2618,
				2900, 2920
			],
			'VIC' => [
				3000, 3999,
				8000, 8999
			],
			'QLD' => [
				4000, 4999,
				9000, 9999
			],
			'SA'  => [
				5000, 5999
			],
			'WA'  => [
				6000, 6797,
				6800, 6999
			],
			'TAS' => [
				7000, 7999
			],
			'NT'  => [
				800, 999
			]
		];
		$exceptions = [
			872  => 'NT',
			2540 => 'NSW',
			2611 => 'ACT',
			2620 => 'NSW',
			3500 => 'VIC',
			3585 => 'VIC',
			3586 => 'VIC',
			3644 => 'VIC',
			3707 => 'VIC',
			2899 => 'NSW',
			6798 => 'WA',
			6799 => 'WA',
			7151 => 'TAS'
		];

		$postcode = intval($postcode);
		if (array_key_exists($postcode, $exceptions)) {
			return $exceptions[$postcode];
		}

		foreach ($ranges as $state => $range) {
			$c = count($range);
			for ($i = 0; $i < $c; $i += 2) {
				$min = $range[$i];
				$max = $range[$i + 1];
				if ($postcode >= $min && $postcode <= $max) {
					return $state;
				}
			}
		}

		return null;
	}

	private function formatName($name)
	{
		$split = explode(' ', $name);

		return [implode(' ', array_slice($split, 0, -1)), implode(' ', array_slice($split, -1))];
	}

	private function getHorseGender($sex)
	{
		switch ($sex) {
			case 'M':
				return 'Mare';
			case 'G':
				return 'Gelding';
			case 'S':
				return 'Stallion';
			default:
				return '';
		}
	}

}
