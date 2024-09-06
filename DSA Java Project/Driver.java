import java.io.File;
import java.io.FileNotFoundException;
import java.util.Scanner;

public class Driver {

    public static void printMenu(){
        String[] options = new String[]{
            "Site info",
            "Insert an edge",
            "Closest site",
            "Exit"
        };
        for(int s=0; s<options.length; s++){
            System.out.println("  " + (s+1) + " - " + options[s]);
        }
    }

    /* public static void printMenu(Site[] sites){
        for(int s=0; s<sites.length; s++){
            System.out.println("  " + (s+1) + " - " + sites[s].getName());
        }
        //System.out.println("  " + (sites.length +1) + " - Exit");
        System.out.println("\n  Type 'e' to exit\n");
    } */

    public static void main(String[] args) {
        File file = new File("./graph.txt");
        int noOfSites;
        Site[] sites;
        int[][] adjacencyMatrix;
        int selectedOption = 0;

        Scanner scanner;
        Scanner inputScanner = new Scanner(System.in);
        try {
            scanner = new Scanner(file);
            noOfSites = Integer.parseInt(scanner.nextLine());
            sites = new Site[noOfSites];
            adjacencyMatrix=new int[noOfSites][noOfSites];
            for(int r=0;r<adjacencyMatrix.length; r++){
                for(int c=0; c<adjacencyMatrix.length; c++){
                        adjacencyMatrix[r][c] = 0;
                }
                System.out.print("\n");
            }

            // get the sites' information
            for(int i=0; i<noOfSites; i++) {
                String[] arr = scanner.nextLine().split(",");
                sites[i] = new Site(Integer.parseInt(arr[0]), arr[1]);
            }

            // get the edges
            while(scanner.hasNextLine()){
                String[] arr = scanner.nextLine().split(",");
                //System.out.println(arr[0] + "\t" + arr[1] + "\t" + arr[2]);
                int site1, site2, weight; 
                site1 = Integer.parseInt(arr[0]);
                site2 = Integer.parseInt(arr[1]);
                weight = Integer.parseInt(arr[2]);

                adjacencyMatrix[site1-1][site2-1] = weight;
                adjacencyMatrix[site2-1][site1-1] = weight;
            }

            for(int r=0;r<adjacencyMatrix.length; r++){
                for(int c=0; c<adjacencyMatrix[r].length; c++){
                        //System.out.print(adjacencyMatrix[r][c] + "\t");
                }
                System.out.print("\n");
            }

            printMenu();
            selectedOption = inputScanner.nextInt();
            while(selectedOption<=0 || selectedOption > 4){
                System.out.println("Invalid input.");
                printMenu();
                selectedOption = inputScanner.nextInt();
            }

            

        } catch (FileNotFoundException e) {
            //e.printStackTrace();
            System.out.println("Incorrect input");
        }


    }
}