<?php
class SecretAgent {
    private $codeName;
    private $codeWord;
    private $mission;

    public function __construct($name, $word, $mission) {
        $this->codeName = $name;
        $this->codeWord = $word;
        $this->mission = $mission;
    }

    public function checkCodeName($test) {
            return $test === $this->getCodeName();
    }



    /**
     * @return mixed
     */
    public function getCodeName()
    {
        return $this->codeName;
    }

    /**
     * @return mixed
     */
    public function getMission($test)
    {
        return $this->checkCodeName($test) ? $this->mission : "Information Denied";
    }

    /**
     * @param mixed $mission
     */
    public function setMission($testName, $testWord, $mission)
    {
        $this->mission = $mission;
    }
}