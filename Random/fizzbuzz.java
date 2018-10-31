/** Fizzbuzz: múltiplos de 3 são printados como 'Fizz' e múltiplos de 5 como 'Buzz' **/

public class fizzbuzz {

public static void main (String[] args) {
	for (int i = 0; i < 100; i++) {
		if (i == 0) {
			System.out.println("0");
		} else if ((i % 3) == 0) {
			System.out.println("Fizz");
		} else if ((i % 5) == 0) {
			System.out.println("Buzz");
		} else {
			System.out.println(i);
		}
	}
}
}