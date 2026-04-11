$text = "I love PHP";
echo str_replace("php", "coding", $text);    // Output: I love PHP (no change)
echo str_ireplace("php", "coding", $text);   //Output: I love coding

echo strcmp("Hello", "hello");      // Returns non-zero (not equal)
echo strcasecmp("Hello", "hello");  // Returns 0 (equal)