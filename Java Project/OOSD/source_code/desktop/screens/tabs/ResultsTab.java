/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens.tabs;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedWriter;
import java.io.FileWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import components.Button;
import components.ResultRecord;
import utils.Colors;
import utils.DB;
import utils.Fonts;
import utils.User;
import utils.Window;
import utils.classes.Result;

public class ResultsTab extends Tab implements ActionListener {

    private final String[] LABELS = { "Game", "Date", "Bet", "Multiplier" };
    private final int[] OFFSET_X = { 20, 110, 300, 450 };

    JPanel table;
    Button saveBtn;
    Result[] results;
    int noOfResults;
    JLabel[] labels;
    ResultRecord[] records;

    private void saveAllResults(String folderPath) {
        Connection connection = null;
        PreparedStatement pstat = null;
        BufferedWriter writer = null;
        ResultSet resultSet = null;

        String date;
        String bet;
        String multiplier;
        String game;
        Result result;

        try {
            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            pstat = connection.prepareStatement(
                    "SELECT timestamp, bet, multiplier, game FROM results WHERE username = ? ORDER BY timestamp DESC");
            pstat.setString(1, User.getUsername());

            resultSet = pstat.executeQuery();

            String filePath = folderPath + "\\results_"
                    + new SimpleDateFormat("yyyy_MM_dd").format(Calendar.getInstance().getTime()) + ".csv";
            writer = new BufferedWriter(new FileWriter(filePath));

            writer.write("Date,Game,Bet,Multiplier\n");

            while (resultSet.next()) {
                date = resultSet.getObject(1).toString().split(" ")[0];
                bet = resultSet.getObject(2).toString();
                multiplier = resultSet.getObject(3).toString();
                game = resultSet.getObject(4).toString();

                result = new Result(date, bet, multiplier, game);

                writer.write(result.getDate() + "," + result.getGame() + "," + result.getBet() + ","
                        + result.getMultiplier() + "\n");
            }

        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                writer.close();
                pstat.close();
                connection.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    private Result[] fetchResults() {
        Result[] results = new Result[9];

        Connection connection = null;
        PreparedStatement pstat = null;
        ResultSet resultSet = null;

        String date;
        String bet;
        String multiplier;
        String game;

        try {
            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            pstat = connection.prepareStatement(
                    "SELECT timestamp, bet, multiplier, game FROM results WHERE username = ? ORDER BY timestamp DESC LIMIT 9");
            pstat.setString(1, User.getUsername());

            resultSet = pstat.executeQuery();

            int i = 0;

            while (resultSet.next()) {
                date = resultSet.getObject(1).toString().split(" ")[0];
                bet = resultSet.getObject(2).toString();
                multiplier = resultSet.getObject(3).toString();
                game = resultSet.getObject(4).toString();

                results[i] = new Result(date, bet, multiplier, game);

                noOfResults++;
                i++;
            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                pstat.close();
                connection.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        return results;
    }

    public void actionPerformed(ActionEvent ev) {
        if (ev.getSource() == saveBtn) {
            JFileChooser fileChooser = new JFileChooser();
            fileChooser.setDialogTitle("Select folder");
            fileChooser.setFileSelectionMode(JFileChooser.DIRECTORIES_ONLY);

            int userSelection = fileChooser.showSaveDialog(new JFrame());

            if (userSelection == JFileChooser.APPROVE_OPTION) {
                String folderPath = fileChooser.getSelectedFile().getAbsolutePath();
                saveAllResults(folderPath);
            }
        }
    }

    public ResultsTab() {
        super("Recent Results");

        table = new JPanel();
        table.setBackground(Colors.BG);
        table.setBounds(PADDING_X, PADDING_Y + TITLE_HEIGHT + 30, WIDTH - PADDING_X * 2, 490);
        table.setLayout(null);

        labels = new JLabel[4];
        for (int i = 0; i < labels.length; i++) {
            labels[i] = new JLabel(LABELS[i]);
            labels[i].setBounds(OFFSET_X[i], 0, 180, 40);
            labels[i].setBackground(Colors.BG);
            labels[i].setForeground(Colors.LABEL);
            labels[i].setFont(Fonts.LABEL);
            table.add(labels[i]);
        }

        results = fetchResults();

        records = new ResultRecord[noOfResults];
        String[] row = new String[3];

        for (int i = 0; i < noOfResults; i++) {
            row[0] = results[i].getDate();
            row[1] = results[i].getBet();
            row[2] = results[i].getMultiplier();
            records[i] = new ResultRecord(row, OFFSET_X, 660, 50, i % 2 == 1 ? Colors.BG : Colors.BG_LIGHT,
                    results[i].getIsWin());
            records[i].setBounds(0, 40 + i * 50, 660, 50);
            table.add(records[i]);
        }

        this.add(table);

        saveBtn = new Button("Save all as CSV");
        saveBtn.setBackground(Colors.PRIMARY);
        saveBtn.setForeground(Colors.BG);
        saveBtn.setFont(Fonts.DEFAULT);
        saveBtn.setBounds(WIDTH - PADDING_X - 200, Window.WINDOW_HEIGHT - PADDING_Y - 60, 200, 46);
        saveBtn.addActionListener(this);
        this.add(saveBtn);
    }

}
