<?php

namespace App\Services\Tools;

class Exception extends \Exception
{
    /**
     * @const string ARGUMENT Used when argument is invalidated
     */
    const ARGUMENT = 'ARGUMENT';

    /**
     * @const string LOGIC Used when logic is invalidated
     */
    const LOGIC = 'LOGIC';

    /**
     * @const string GENERAL Used when anything in general is invalidated
     */
    const GENERAL = 'GENERAL';

    /**
     * @const string CRITICAL Used when anything caused application to crash
     */
    const CRITICAL = 'CRITICAL';

    /**
     * @const string WARNING Used to inform developer without crashing
     */
    const WARNING = 'WARNING';

    /**
     * @const string ERROR Used when code was thrown
     */
    const ERROR = 'ERROR';

    /**
     * @const string DEBUG Used for temporary developer output
     */
    const DEBUG = 'DEBUG';

    /**
     * @const string INFORMATION Used for permanent developer notes
     */
    const INFORMATION = 'INFORMATION';

    /**
     * @var string|null $reporter class name that it came from
     */
    protected $reporter = null;

    /**
     * @var string $type exception type
     */
    protected $type = self::LOGIC;

    /**
     * @var string $level level of exception
     */
    protected $level = self::ERROR;

    /**
     * @var int $offset used for false positives on the trace
     */
    protected $offset = 1;

    /**
     * @var array $variables used for sprintf messages
     */
    protected $variables = array();

    /**
     * @var array $trace the back trace
     */
    protected $trace = array();


    public static function i($message = null, $code = 0)
    {
        $class = get_called_class();
        return new $class($message, $code);
    }


    public function addVariable($variable)
    {
        $this->variables[] = $variable;
        return $this;
    }

    /**
     * Returns the exception level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Returns raw trace
     *
     * @return array
     */
    public function getRawTrace()
    {
        return $this->trace;
    }

    /**
     * Returns the class or method that caught this
     *
     * @return string
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * Returns the trace offset; where we should start the trace
     *
     * @return Eden\Core\Exception
     */
    public function getTraceOffset()
    {
        return $this->offset;
    }

    /**
     * Returns the exception type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns variables
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }


    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }


    public function setLevelDebug()
    {
        return $this->setLevel(self::DEBUG);
    }


    public function setLevelError()
    {
        return $this->setLevel(self::WARNING);
    }


    public function setLevelInformation()
    {
        return $this->setLevel(self::INFORMATION);
    }


    public function setLevelWarning()
    {
        return $this->setLevel(self::WARNING);
    }


    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }


    public function setTraceOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }


    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    public function setTypeArgument()
    {
        return $this->setType(self::ARGUMENT);
    }


    public function setTypeCritical()
    {
        return $this->setType(self::CRITICAL);
    }


    public function setTypeGeneral()
    {
        return $this->setType(self::GENERAL);
    }


    public function setTypeLogic()
    {
        return $this->setType(self::CRITICAL);
    }


    public function trigger()
    {
        $this->trace = debug_backtrace();

        $this->reporter = get_class($this);
        if (isset($this->trace[$this->offset]['class'])) {
            $this->reporter = $this->trace[$this->offset]['class'];
        }

        if (isset($this->trace[$this->offset]['file'])) {
            $this->file = $this->trace[$this->offset]['file'];
        }

        if (isset($this->trace[$this->offset]['line'])) {
            $this->line = $this->trace[$this->offset]['line'];
        }

        if (!empty($this->variables)) {
            $this->message = vsprintf($this->message, $this->variables);
            $this->variables = array();
        }

        throw $this;
    }
}
