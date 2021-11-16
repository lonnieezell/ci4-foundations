<?php

namespace App\Commands;

use App\Models\ProductModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Files\File;

class ImportProducts extends BaseCommand
{
	/**
	 * The Command's Group
	 *
	 * @var string
	 */
	protected $group = 'Imports';

	/**
	 * The Command's Name
	 *
	 * @var string
	 */
	protected $name = 'import:products';

	/**
	 * The Command's Description
	 *
	 * @var string
	 */
	protected $description = 'Imports sample product CSV file';

	/**
	 * The Command's Usage
	 *
	 * @var string
	 */
	protected $usage = 'import:products <fileName> [options]';

	/**
	 * The Command's Arguments
	 *
	 * @var array
	 */
	protected $arguments = [
        'fileName' => 'The name of the file to import'
    ];

	/**
	 * The Command's Options
	 *
	 * @var array
	 */
	protected $options = [
        '--dir' => 'The directory to look in, relative to ROOTPATH. Default: app/Resources'
    ];

	/**
	 * Actually execute a command.
	 *
	 * @param array $params
	 */
	public function run(array $params)
	{
        $fileName = $params[0] ?? CLI::prompt('file name');
        $dir = CLI::getOption('dir') ?? APPPATH .'Resources/';

        if (! is_file($dir . $fileName)) {
            CLI::error('Invalid file: '. $dir . $fileName);
            exit();
        }

		$headers = [
            'name', 'manufacturer', 'location', 'category'
        ];

        $fileInfo = new File($dir . $fileName);
        $file = $fileInfo->openFile();
        $file->setFlags(\SplFileObject::READ_CSV);

        $model = new ProductModel();

        $totalLines = $this->calcTotalLines($file);
        $currentStep = 1;

        foreach ($file as $row) {
            CLI::showProgress($currentStep++, $totalLines);

            [$name, $manufacturer, $location, $category] = $row;

            $model->insert([
                'name' => $name,
                'manufacturer' => $manufacturer,
                'location' => $location,
                'category' => $category
            ]);
        }

        CLI::showProgress(false);

        CLI::write('Import complete', 'green');
	}

    private function calcTotalLines(\SplFileObject $file)
    {
        $lineCount = 0;
        while($file->valid()) {
            $line = $file->fgets();
            $lineCount += substr_count($line, PHP_EOL);
        }

        return $lineCount;
    }
}
