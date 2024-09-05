package utils;

public class User {

    private static String username;

    public static void setUsername(String username) {
        User.username = username;
    }

    public static String getUsername() {
        return User.username;
    }

}
