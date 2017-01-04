<?php namespace Helios;

/**
 * Helios' brain. Responsible for managing the AI.
 */
class Helios
{
    /**
     * For outward communication.
     *
     * @var Helios\Modules\Output\Output
     */
    protected $output;

    /**
     * For inward communication.
     *
     * @var Helios\Modules\Input\Input
     */
    protected $input;

    /**
     * Helios' storage.
     *
     * @var Helios\Modules\Storage\Storage
     */
    protected $storage;

    /**
     * Analyse a statement's sentiment.
     *
     * @var Helios\Modules\NLP\Sentiment\Sentiment
     */
    protected $sentiment;

    /**
     * Set-up Helios.
     *
     * @return void
     */
    public function __construct()
    {
        // Load the modules config and set-up with the set options
        $config = new \Noodlehaus\Config(__DIR__ . '/../Config/Modules.php');

        $this->output    = $config->get('Output');
        $this->input     = $config->get('Input');
        $this->storage   = $config->get('Storage');
        $this->sentiment = $config->get('Sentiment');
    }

    /**
     * Wake up.
     *
     * @return void
     */
    public function wakeUp()
    {
        $this->output->write('I am awake.');
        $this->commsLoop();
        $this->goToSleep();
    }

    /**
     * Start the communication loop.
     *
     * @return void
     */
    public function commsLoop()
    {
        while (($input = $this->input->request('What can I do for you?')) != 'Goodbye') {
            $this->output->write('You said: ' . $input);
            $this->output->write('I believe that is ' . $this->sentiment->check($input));
        }
    }

    /**
     * Shut Helios down.
     *
     * @return void
     */
    public function goToSleep()
    {
        $this->output->write('Goodbye.');
    }
}
