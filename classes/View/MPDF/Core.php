<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Render a view as a PDF.
 *
 * @packge     Kohana-mPDF
 * @author     Woody Gilk <woody.gilk@kohanaphp.com>
 * @author     Sergei Gladkovskiy <smgladkovskiy@gmail.com>
 * @author     Maciej Kwiatkowski <kodzitsu@gmail.com>
 * @copyright  (c) 2009 Woody Gilk
 * @license    MIT
 */
abstract class View_MPDF_Core extends View {

	protected $mpdf = NULL;
	protected $view_file = NULL;

	public function __construct($file = NULL, array $data = NULL, $mpdf = null)
	{
		parent::__construct($file, $data);
                if($mpdf != null and is_a($mpdf, 'mPDF'))
                {
                    $this->mpdf = $mpdf;
                }
                else
                {
                    $this->mpdf = new mPDF('UTF-8', 'A4');
                }
	}

	public static function factory($view_file = NULL, array $data = NULL, $mpdf = null)
	{
		return new View_MPDF($view_file, $data, $mpdf);
	}

	/*
	 * Get an instance of MPDF object
	 */
	public function get_mpdf()
	{
		return $this->mpdf;
	}

	public function __toString()
	{
		return $this->as_string();
	}

	public function as_string($view_file = NULL)
	{
		if (empty($view_file)) $view_file = $this->view_file;

		$html = parent::render($view_file);
		$this->mpdf->WriteHTML($html);

		return $this->mpdf->output(FALSE, 'S');
	}

	public function download($generated_filename, $view_file = NULL)
	{
		if (empty($view_file)) $view_file = $this->view_file;

		$html = parent::render($view_file);
		$this->mpdf->WriteHTML($html);

		return $this->mpdf->output($generated_filename, 'D');
	}

	public function inline($generated_filename, $view_file = NULL)
	{
		if (empty($view_file)) $view_file = $this->view_file;

		$html = parent::render($view_file);
		$this->mpdf->WriteHTML($html);

		// Necessary to prevent Kohana from overriding the content-type set inside the previous function - we
		// explictly set it to the correct type here...
		Request::$current->headers('content-type', 'application/pdf');

		return $this->mpdf->output($generated_filename, 'I');
	}

	public function write_to_disk($filename, $view_file = NULL)
	{
		if (empty($view_file)) $view_file = $this->view_file;

		$html = parent::render($view_file);
		$this->mpdf->WriteHTML($html);

		return $this->mpdf->output($filename, 'F');
	}

} // End View_mPDF_Core
