test:
	echo 'no tests yet'

doc:
	./vendor/bin/phpdoc -d src/ -t docs/master

clean:
	rm -rf docs/cache/
