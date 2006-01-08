CC=javac
#CC=gcj -C

all: JavaIdentificationsOnAFigureJarFile.jar

JavaIdentificationsOnAFigureJarFile.jar: JavaIdentificationsOnAFigure.class JavaIdentificationsOnAFigureLabel.class
	jar -cf JavaIdentificationsOnAFigureJarFile.jar *.class
	cp JavaIdentificationsOnAFigureJarFile.jar ..

JavaIdentificationsOnAFigure.class: JavaIdentificationsOnAFigure.java
	$(CC)  JavaIdentificationsOnAFigure.java

JavaIdentificationsOnAFigureLabel.class: JavaIdentificationsOnAFigureLabel.java
	$(CC)  JavaIdentificationsOnAFigureLabel.java

clean:
	rm *.class *.jar