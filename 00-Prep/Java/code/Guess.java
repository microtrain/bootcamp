import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
//import java.io.PrintStream;
import java.util.Random;

public class Guess
{
    public static void main(String[] args) throws IOException
    {

        Random rand = new Random();
        int randNum = rand.nextInt((10 - 1) + 1) + 1;

        System.out.println("Pick a number between 1 and 10: ");

        BufferedReader reader =
          new BufferedReader(new InputStreamReader(System.in));
        String guess = reader.readLine();
        System.out.print("You picked " + guess);

        int theGuess = Integer.parseInt(guess);

        if(theGuess == randNum){
          System.out.println(", WE HAVE A WINNER!");
        }else{
          System.out.println(", I'm sorry the answer was " + randNum);
        }

    }
}
