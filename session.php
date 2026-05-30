<?php
// Session extension for Yellow CMS
// Provides a simple PHP session management

class YellowSession {
    const VERSION = "0.0.1";
    public $yellow;

    // Initialize session automatically when the extension loads
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    // Handle page content element
    public function onParseContentElement($page, $name, $text, $attributes, $type) {
        $output = null;
        if ($name=="session" && ($type=="block" || $type=="inline")) {
            $output = "";
        
            list($comand, $key, $value) = $this->yellow->toolbox->getTextArguments($text);

            // Set Session with [session set key value]
            if ($comand=="set" && !empty($key) && !empty($value)) $this->setSession($key, $value);
            
            // Get Session with [session get key]
            if ($comand=="get" && !empty($key)) {
            
                if (!empty($this->getSession($key))) $output = trim($this->parseText($this->yellow->page, $this->getSession($key)));
                // Alternative output if key is empty. 
                if (empty($this->getSession($key)) && !empty($value)) $output = trim($this->parseText($this->yellow->page, $value));
            }
            
            // Delete Session with [session del key]
            if ($comand=="del" && !empty($key)) $this->deleteSession($key);
        
        }
        return $output;
    }
    

    // Sets a session value (Starts session if needed)  
    public function setSession($key, $value) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Lazy Init
        }
        $_SESSION[$key] = $value;
    }

    // Gets a session value (Returns null if no session is active)
    public function getSession($key) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return $_SESSION[$key] ?? null;
        }
        return null; 
    }

    // Deletes a session value (Only if session is already active)
    public function deleteSession($key) {
        if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }
    
    // Parses markdown text using the system's default parser
    private function parseText($page, $text, $singleLine = true) {
        $parser = $this->yellow->extension->get($this->yellow->system->get("parser"));
        $output = $parser->onParseContentRaw($page, $text);
        return $output;       
    } 
}
