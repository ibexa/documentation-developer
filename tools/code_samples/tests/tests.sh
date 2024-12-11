cp tools/code_samples/tests/docs/tests.md docs/;
php tools/code_samples/code_samples_usage.php `find tools/code_samples/tests/code_samples -type f -a -name 'test.*' | sort` > tools/code_samples/tests/tests.current.tmp.txt;
diff tools/code_samples/tests/tests.expected.txt tools/code_samples/tests/tests.current.tmp.txt;
if [ 0 -ne $? ]; then
  echo 'Not as expected.';
fi
rm -f tools/code_samples/tests/docs/tests.md tools/code_samples/tests/tests.current.tmp.txt;
